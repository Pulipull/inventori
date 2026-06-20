<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\Item;
use App\Models\IntegrationOutboxEvent;
use App\Models\IntegrationWebhookLog;
use App\Models\AppNotification;
use App\Models\Order;
use App\Models\ReportExport;
use App\Models\StockTransaction;
use App\Models\StorageFile;
use App\Services\ChatService;
use App\Services\CRMService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(ChatService $chat, CRMService $crm): View
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            $orderSummary = Order::where('user_id', $user->id)
                ->selectRaw('count(*) as total')
                ->selectRaw("sum(case when status = 'paid' then 1 else 0 end) as paid")
                ->selectRaw("sum(case when status = 'pending' then 1 else 0 end) as pending")
                ->first();

            return view('user.dashboard', [
                'orderSummary' => $orderSummary,
                'orders' => Order::with('item')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->paginate(10),
                'items' => Item::with('category')
                    ->where('stock', '>', 0)
                    ->latest()
                    ->limit(8)
                    ->get(),
            ]);
        }

        $chatMetrics = $chat->conversationMetrics($user);

        return view('dashboard', [
            'itemCount' => Item::count(),
            'categoryCount' => Category::count(),
            'customerCount' => Customer::count(),
            'openFollowUpCount' => CustomerFollowUp::where('status', CustomerFollowUp::STATUS_OPEN)->count(),
            'completedFollowUpCount' => CustomerFollowUp::where('status', CustomerFollowUp::STATUS_DONE)->count(),
            'reportExportCount' => ReportExport::count(),
            'storageFileCount' => StorageFile::count(),
            'pendingIntegrationEventCount' => IntegrationOutboxEvent::where('status', IntegrationOutboxEvent::STATUS_PENDING)->count(),
            'processedIntegrationEventCount' => IntegrationOutboxEvent::where('status', IntegrationOutboxEvent::STATUS_PROCESSED)->count(),
            'unreadNotificationCount' => AppNotification::where('user_id', $user->id)->whereNull('read_at')->count(),
            'activeConversationCount' => $chatMetrics['active_conversations'],
            'unreadConversationCount' => $chatMetrics['unread_conversations'],
            'recentReportExports' => ReportExport::with('user')->latest()->limit(5)->get(),
            'recentStorageFiles' => StorageFile::with('user')->latest()->limit(5)->get(),
            'recentWebhookLogs' => IntegrationWebhookLog::latest('received_at')->limit(5)->get(),
            'lowStockCount' => Item::whereColumn('stock', '<=', 'minimum_stock')->where('stock', '>', 0)->count(),
            'emptyStockCount' => Item::where('stock', '<=', 0)->count(),
            'recentTransactions' => StockTransaction::with(['item', 'user'])->latest()->limit(8)->get(),
            'lowItems' => Item::with('category')->whereColumn('stock', '<=', 'minimum_stock')->orderBy('stock')->limit(8)->get(),
            'recentCrmActivities' => $crm->recentActivities(),
        ]);
    }
}
