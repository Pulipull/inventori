<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerInteraction;
use App\Models\Order;
use App\Models\StockTransaction;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class DokuPaymentService
{
    private const ORDER_STATUSES = ['pending', 'paid', 'failed', 'expired'];

    private ?string $clientId;
    private ?string $secretKey;
    private string $apiUrl;

    public function __construct(
        private readonly InventoryService $inventory,
        private readonly NotificationService $notifications,
        private readonly CRMService $crm,
    )
    {
        $this->clientId = config('services.doku.mall_id');
        $this->secretKey = config('services.doku.shared_key');
        $this->apiUrl = rtrim(config('services.doku.api_url') ?: 'https://api-sandbox.doku.com', '/');
    }

    public function isConfigured(): bool
    {
        return filled($this->clientId) && filled($this->secretKey) && filled($this->apiUrl);
    }

    public function createCheckoutUrl(
        string $invoiceNo,
        float $amount,
        string $customerName,
        string $customerEmail,
        string $redirectUrl,
        ?string $description = null,
        array $lineItems = []
    ): string {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Doku belum dikonfigurasi. Pesanan tetap bisa dibuat, tetapi pembayaran online belum aktif.');
        }

        $amount = (int) round($amount);

        if ($amount < 1000) {
            throw new RuntimeException('Nominal pembayaran Doku minimal Rp 1.000.');
        }

        $targetPath = '/checkout/v1/payment';
        $lineItems = $lineItems ?: [[
            'name' => $description ?: 'Pesanan inventori',
            'quantity' => 1,
            'price' => $amount,
            'category' => 'retail',
        ]];

        $body = [
            'order' => [
                'amount' => $amount,
                'invoice_number' => $this->sanitizeInvoiceNumber($invoiceNo),
                'currency' => 'IDR',
                'callback_url' => $redirectUrl,
                'callback_url_result' => $redirectUrl,
                'language' => 'ID',
                'auto_redirect' => true,
                'line_items' => $lineItems,
            ],
            'payment' => [
                'payment_due_date' => 60,
            ],
            'customer' => [
                'id' => 'USER-'.$this->sanitizeText((string) auth()->id(), 40),
                'name' => $this->sanitizeText($customerName, 120),
                'email' => $customerEmail,
            ],
            'additional_info' => [
                'override_notification_url' => config('services.doku.notification_url') ?: route('doku.callback'),
            ],
        ];

        $headers = $this->headers('POST', $targetPath, $body);

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->withHeaders($headers)
                ->timeout(20)
                ->post($this->apiUrl.$targetPath, $body)
                ->throw()
                ->json();
        } catch (RequestException $exception) {
            $message = $exception->response?->json('error_messages.0')
                ?? $exception->response?->body()
                ?? $exception->getMessage();

            Log::error('Doku checkout request failed', [
                'invoice_number' => $invoiceNo,
                'status' => $exception->response?->status(),
                'message' => $message,
            ]);

            throw new RuntimeException('Doku menolak checkout: '.(is_scalar($message) ? $message : json_encode($message)));
        }

        $paymentUrl = data_get($response, 'response.payment.url');

        if (! is_string($paymentUrl) || $paymentUrl === '') {
            Log::error('Doku checkout response missing payment URL', [
                'invoice_number' => $invoiceNo,
                'response' => $response,
            ]);

            throw new RuntimeException('Doku tidak mengembalikan URL pembayaran.');
        }

        return $paymentUrl;
    }

    public function queryTransactionStatus(string $invoiceNo): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $targetPath = '/orders/v1/status/'.$this->sanitizeInvoiceNumber($invoiceNo);

        try {
            $response = Http::acceptJson()
                ->withHeaders($this->headers('GET', $targetPath))
                ->timeout(15)
                ->get($this->apiUrl.$targetPath);

            return $response->successful() ? $response->json() : null;
        } catch (Throwable $exception) {
            Log::warning('Doku query status error', [
                'invoice_number' => $invoiceNo,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public function handleCallback(array $data): array
    {
        try {
            $invoiceNumber = data_get($data, 'order.invoice_number')
                ?? data_get($data, 'order.invoice_number.value')
                ?? data_get($data, 'INVOICE_NUMBER')
                ?? data_get($data, 'invoice_number');

            $status = strtoupper((string) (
                data_get($data, 'transaction.status')
                ?? data_get($data, 'transaction_status')
                ?? data_get($data, 'STATUS_CODE')
                ?? data_get($data, 'status')
            ));

            if (! $invoiceNumber || ! $status) {
                throw new RuntimeException('Missing required callback parameters');
            }

            $orderStatus = match ($status) {
                'SUCCESS', 'SUCCEEDED', 'SETTLEMENT', 'CAPTURED', '0' => 'paid',
                'PENDING', '99', 'REDIRECT', 'TIMEOUT' => 'pending',
                'EXPIRED', 'ORDER_EXPIRED' => 'expired',
                default => 'failed',
            };

            return [
                'success' => true,
                'invoice_number' => $invoiceNumber,
                'status' => $orderStatus,
                'transaction_id' => data_get($data, 'transaction.original_request_id')
                    ?? data_get($data, 'transaction.id')
                    ?? data_get($data, 'REFERENCE'),
                'response' => $data,
            ];
        } catch (Throwable $e) {
            Log::error('Doku callback error: ' . $e->getMessage(), $data);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function applyOrderStatus(
        Order $order,
        string $status,
        ?string $transactionId = null,
        array $response = [],
    ): Order {
        return DB::transaction(function () use ($order, $status, $transactionId, $response) {
            if (! in_array($status, self::ORDER_STATUSES, true)) {
                throw new RuntimeException('Status pembayaran tidak valid.');
            }

            $order = Order::query()
                ->with(['item', 'user'])
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $previousStatus = $order->status;

            if ($previousStatus === 'paid' && $status !== 'paid') {
                Log::warning('Ignoring stale Doku status for paid order', [
                    'order_id' => $order->id,
                    'invoice_number' => $order->invoice_number,
                    'current_status' => $previousStatus,
                    'incoming_status' => $status,
                ]);

                return $order;
            }

            $order->update([
                'status' => $status,
                'doku_transaction_id' => $transactionId ?: $order->doku_transaction_id,
                'doku_response' => $response ?: $order->doku_response,
                'paid_at' => $status === 'paid' ? ($order->paid_at ?: now()) : $order->paid_at,
            ]);

            if ($previousStatus !== 'paid' && $status === 'paid') {
                $this->handlePaidOrder($order->fresh(['item', 'user']));
            }

            if ($previousStatus !== $status && in_array($status, ['failed', 'expired'], true)) {
                $this->notifyBuyerPaymentStatus($order->fresh('user'), $status);
            }

            return $order->fresh(['item', 'user']);
        });
    }

    public function verifyCallbackSignature(Request $request): bool
    {
        if (! filled($this->clientId) || ! filled($this->secretKey)) {
            return false;
        }

        $signature = (string) $request->header('Signature', '');
        $requestId = (string) $request->header('Request-Id', '');
        $timestamp = (string) $request->header('Request-Timestamp', '');
        $clientId = (string) $request->header('Client-Id', '');

        if ($signature === '' || $requestId === '' || $timestamp === '' || $clientId === '') {
            return false;
        }

        if (! hash_equals((string) $this->clientId, $clientId)) {
            return false;
        }

        $requestTarget = '/'.$request->path();
        $body = $request->getContent();
        $digest = base64_encode(hash('sha256', $body, true));

        $headerDigest = (string) $request->header('Digest', '');
        if ($headerDigest !== '' && ! hash_equals($digest, $headerDigest)) {
            return false;
        }

        $component = "Client-Id:{$clientId}\n"
            ."Request-Id:{$requestId}\n"
            ."Request-Timestamp:{$timestamp}\n"
            ."Request-Target:{$requestTarget}\n"
            ."Digest:{$digest}";

        $expected = 'HMACSHA256='.base64_encode(hash_hmac('sha256', $component, (string) $this->secretKey, true));

        return hash_equals($expected, $signature);
    }

    public function mapStatusResponse(array $data): ?string
    {
        $status = strtoupper((string) (
            data_get($data, 'transaction.status')
            ?? data_get($data, 'order.status')
            ?? data_get($data, 'transaction_status')
            ?? ''
        ));

        return match ($status) {
            'SUCCESS', 'SUCCEEDED', 'SETTLEMENT', 'CAPTURED' => 'paid',
            'EXPIRED', 'ORDER_EXPIRED' => 'expired',
            'FAILED' => 'failed',
            'PENDING', 'REDIRECT', 'ORDER_GENERATED', 'ORDER_GENERATE' => 'pending',
            default => null,
        };
    }

    private function handlePaidOrder(Order $order): void
    {
        $this->recordInventoryTransaction($order);
        $this->notifyPaymentSuccess($order);
        $this->recordCrmPaymentInteraction($order);
    }

    private function recordInventoryTransaction(Order $order): void
    {
        if (! $order->item || ! $order->user) {
            return;
        }

        $notes = $this->paymentCompletedDescription($order);

        $alreadyRecorded = StockTransaction::query()
            ->where('item_id', $order->item_id)
            ->where('user_id', $order->user_id)
            ->where('type', StockTransaction::TYPE_OUT)
            ->where('notes', $notes)
            ->exists();

        if ($alreadyRecorded) {
            return;
        }

        try {
            $this->inventory->record(
                $order->item,
                $order->user,
                StockTransaction::TYPE_OUT,
                1,
                now()->toDateString(),
                $notes,
            );
        } catch (InvalidArgumentException $exception) {
            Log::warning('Paid order could not record inventory transaction', [
                'order_id' => $order->id,
                'invoice_number' => $order->invoice_number,
                'item_id' => $order->item_id,
                'message' => $exception->getMessage(),
            ]);

            $this->notifyAdminsInventoryIssue($order, $exception->getMessage());
        }
    }

    private function notifyPaymentSuccess(Order $order): void
    {
        if ($order->user) {
            $this->notifications->create(
                $order->user,
                'Pembayaran berhasil',
                'Pembayaran untuk order '.$order->invoice_number.' berhasil.',
                'success',
                'system',
            );
        }

        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->create(
                $admin,
                'Pembayaran diterima',
                'Order '.$order->invoice_number.' sudah dibayar.',
                'success',
                'system',
            ));
    }

    private function notifyBuyerPaymentStatus(Order $order, string $status): void
    {
        if (! $order->user) {
            return;
        }

        $message = $status === 'expired'
            ? 'Pembayaran untuk order '.$order->invoice_number.' sudah expired.'
            : 'Pembayaran untuk order '.$order->invoice_number.' gagal.';

        $this->notifications->create(
            $order->user,
            $status === 'expired' ? 'Pembayaran expired' : 'Pembayaran gagal',
            $message,
            $status === 'expired' ? 'warning' : 'danger',
            'system',
        );
    }

    private function notifyAdminsInventoryIssue(Order $order, string $message): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->create(
                $admin,
                'Stok order perlu dicek',
                'Order '.$order->invoice_number.' sudah dibayar, tetapi stok gagal dicatat: '.$message,
                'warning',
                'system',
            ));
    }

    private function recordCrmPaymentInteraction(Order $order): void
    {
        if (! $order->user) {
            return;
        }

        $customer = $this->customerForOrder($order);

        if (! $customer) {
            return;
        }

        $description = $this->paymentCompletedDescription($order);

        $alreadyRecorded = CustomerInteraction::query()
            ->where('customer_id', $customer->id)
            ->where('type', 'order')
            ->where('description', $description)
            ->exists();

        if ($alreadyRecorded) {
            return;
        }

        $this->crm->logInteraction($customer, $order->user, [
            'type' => 'order',
            'summary' => 'Order '.$order->invoice_number.' paid',
            'description' => $description,
            'occurred_at' => $order->paid_at ?: now(),
        ]);
    }

    private function customerForOrder(Order $order): ?Customer
    {
        $user = $order->user;

        if (! $user) {
            return null;
        }

        $customer = Customer::query()
            ->where('user_id', $user->id)
            ->first();

        if (! $customer && $user->email) {
            $customer = Customer::query()
                ->whereRaw('LOWER(email) = ?', [mb_strtolower($user->email)])
                ->first();
        }

        if ($customer) {
            if (! $customer->user_id) {
                $this->crm->updateCustomer($customer, ['user_id' => $user->id], $user);
                $customer->refresh();
            }

            return $customer;
        }

        return $this->crm->createCustomer([
            'external_customer_id' => 'USER-'.$user->id,
            'user_id' => $user->id,
            'source' => 'payment',
            'name' => $user->name,
            'email' => $user->email,
            'phone' => null,
            'company' => null,
            'status' => 'active',
            'notes' => 'Customer dibuat otomatis dari payment order '.$order->invoice_number.'.',
        ], $user);
    }

    private function paymentCompletedDescription(Order $order): string
    {
        return 'Payment completed for order '.$order->invoice_number;
    }

    private function headers(string $method, string $targetPath, ?array $body = null): array
    {
        $requestId = (string) str()->uuid();
        $timestamp = $this->requestTimestamp();
        $clientId = (string) $this->clientId;
        $secretKey = (string) $this->secretKey;

        $component = "Client-Id:{$clientId}\n"
            ."Request-Id:{$requestId}\n"
            ."Request-Timestamp:{$timestamp}\n"
            ."Request-Target:{$targetPath}";

        $headers = [
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
        ];

        if ($method !== 'GET' && $body !== null) {
            $digest = base64_encode(hash('sha256', json_encode($body), true));
            $component .= "\nDigest:{$digest}";
            $headers['Digest'] = $digest;
        }

        $signature = base64_encode(hash_hmac('sha256', $component, $secretKey, true));
        $headers['Signature'] = 'HMACSHA256='.$signature;

        return $headers;
    }

    private function sanitizeInvoiceNumber(string $invoiceNo): string
    {
        return substr(preg_replace('/[^A-Za-z0-9]/', '', $invoiceNo) ?: $invoiceNo, 0, 30);
    }

    private function sanitizeText(string $value, int $maxLength): string
    {
        $value = preg_replace('/[^A-Za-z0-9 @._-]/', '', $value) ?: $value;

        return substr($value, 0, $maxLength);
    }

    private function requestTimestamp(): string
    {
        try {
            $dateHeader = Http::timeout(5)->head($this->apiUrl)->header('Date');

            if (is_string($dateHeader) && $dateHeader !== '') {
                return CarbonImmutable::parse($dateHeader)->utc()->format('Y-m-d\TH:i:s\Z');
            }
        } catch (Throwable $exception) {
            Log::warning('Doku server time lookup failed', ['message' => $exception->getMessage()]);
        }

        return gmdate('Y-m-d\TH:i:s\Z');
    }
}
