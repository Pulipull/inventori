<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\StockTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function stock(): View
    {
        return view('reports.stock', ['items' => Item::with('category')->orderBy('name')->get()]);
    }

    public function stockPdf()
    {
        $pdf = Pdf::loadView('reports.pdf.stock', ['items' => Item::with('category')->orderBy('name')->get()]);
        return $pdf->download('laporan-stok-barang.pdf');
    }

    public function transactions(Request $request, string $type): View
    {
        abort_unless(in_array($type, ['in', 'out'], true), 404);
        $filters = $this->dateFilters($request);

        return view('reports.transactions', [
            'type' => $type,
            'transactions' => $this->transactionQuery($filters, $type)->get(),
        ]);
    }

    public function transactionsPdf(Request $request, string $type)
    {
        abort_unless(in_array($type, ['in', 'out'], true), 404);
        $filters = $this->dateFilters($request);

        $pdf = Pdf::loadView('reports.pdf.transactions', [
            'type' => $type,
            'transactions' => $this->transactionQuery($filters, $type)->get(),
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
        ]);

        return $pdf->download('laporan-barang-'.($type === 'in' ? 'masuk' : 'keluar').'.pdf');
    }

    public function sales(Request $request): View
    {
        $filters = $this->dateFilters($request);

        return view('reports.sales', [
            'orders' => $this->salesQuery($filters)->get(),
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
        ]);
    }

    public function salesPdf(Request $request)
    {
        $filters = $this->dateFilters($request);
        $orders = $this->salesQuery($filters)->get();
        
        $pdf = Pdf::loadView('reports.pdf.sales', [
            'orders' => $orders,
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
            'total' => $orders->sum('amount'),
        ]);

        return $pdf->download('laporan-penjualan.pdf');
    }

    public function payments(Request $request): View
    {
        $filters = $this->dateFilters($request);

        return view('reports.payments', [
            'orders' => $this->paymentsQuery($filters)->get(),
            'summary' => $this->paymentsSummary($filters),
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
        ]);
    }

    public function paymentsPdf(Request $request)
    {
        $filters = $this->dateFilters($request);
        $orders = $this->paymentsQuery($filters)->get();
        $summary = $this->paymentsSummary($filters);
        
        $pdf = Pdf::loadView('reports.pdf.payments', [
            'orders' => $orders,
            'summary' => $summary,
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
        ]);

        return $pdf->download('laporan-pembayaran.pdf');
    }

    public function revenue(Request $request): View
    {
        $filters = $this->dateFilters($request);

        return view('reports.revenue', [
            'summary' => $this->revenueSummary($filters),
            'orders' => $this->salesQuery($filters)->get(),
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
        ]);
    }

    public function revenuePdf(Request $request)
    {
        $filters = $this->dateFilters($request);
        $summary = $this->revenueSummary($filters);
        $orders = $this->salesQuery($filters)->get();
        
        $pdf = Pdf::loadView('reports.pdf.revenue', [
            'summary' => $summary,
            'orders' => $orders,
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
        ]);

        return $pdf->download('laporan-pendapatan.pdf');
    }

    private function transactionQuery(array $filters, string $type)
    {
        return StockTransaction::with(['item.category', 'user'])
            ->where('type', $type)
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->whereDate('transaction_date', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->whereDate('transaction_date', '<=', $date))
            ->orderByDesc('transaction_date');
    }

    private function salesQuery(array $filters)
    {
        return Order::with(['user', 'item'])
            ->where('status', 'paid')
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->whereDate('paid_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->whereDate('paid_at', '<=', $date))
            ->orderByDesc('paid_at');
    }

    private function paymentsQuery(array $filters)
    {
        return Order::with(['user', 'item'])
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->whereDate('created_at', '<=', $date))
            ->orderByDesc('created_at');
    }

    private function paymentsSummary(array $filters): array
    {
        $query = Order::query()
            ->when($filters['date_from'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date));

        return [
            'total_orders' => $query->count(),
            'paid' => (clone $query)->where('status', 'paid')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'failed' => (clone $query)->where('status', 'failed')->count(),
            'expired' => (clone $query)->where('status', 'expired')->count(),
            'total_amount' => (clone $query)->sum('amount'),
            'paid_amount' => (clone $query)->where('status', 'paid')->sum('amount'),
        ];
    }

    private function revenueSummary(array $filters): array
    {
        $query = Order::where('status', 'paid')
            ->when($filters['date_from'] ?? null, fn ($q, $date) => $q->whereDate('paid_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($q, $date) => $q->whereDate('paid_at', '<=', $date));

        return [
            'total_revenue' => $query->sum('amount'),
            'total_transactions' => $query->count(),
            'average_transaction' => $query->count() > 0 ? $query->sum('amount') / $query->count() : 0,
            'by_item' => Order::select('item_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
                ->with('item')
                ->where('status', 'paid')
                ->when($filters['date_from'] ?? null, fn ($q, $date) => $q->whereDate('paid_at', '>=', $date))
                ->when($filters['date_to'] ?? null, fn ($q, $date) => $q->whereDate('paid_at', '<=', $date))
                ->whereNotNull('item_id')
                ->groupBy('item_id')
                ->orderByDesc('total')
                ->get(),
        ];
    }

    private function dateFilters(Request $request): array
    {
        $filters = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
        ]);

        if (
            isset($filters['date_from'], $filters['date_to'])
            && CarbonImmutable::parse($filters['date_to'])->lt(CarbonImmutable::parse($filters['date_from']))
        ) {
            throw ValidationException::withMessages([
                'date_to' => 'Tanggal akhir harus sama dengan atau setelah tanggal awal.',
            ]);
        }

        return $filters;
    }
}
