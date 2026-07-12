<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerFeedbackController;
use App\Http\Controllers\CustomerFollowUpController;
use App\Http\Controllers\CustomerInteractionController;
use App\Http\Controllers\CustomerTimelineController;
use App\Http\Controllers\CrmFeedbackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokuCallbackController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntegrationWebhookController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Doku callback (public, no auth required)
Route::post('/doku/callback', [DokuCallbackController::class, 'handle'])->name('doku.callback');
Route::get('/doku/return', [CheckoutController::class, 'returnFromDoku'])->name('doku.return');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/system', SystemController::class)->name('system.index')->middleware('role:super_admin');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/tracking', [TrackingController::class, 'track'])->name('tracking.track');

    Route::prefix('feedback')->name('feedback.')->middleware('role:user')->group(function () {
        Route::get('/', [CustomerFeedbackController::class, 'index'])->name('index');
        Route::get('/create', [CustomerFeedbackController::class, 'create'])->name('create');
        Route::post('/', [CustomerFeedbackController::class, 'store'])->name('store');
    });

    Route::prefix('storage')->name('storage.')->middleware('role:super_admin')->group(function () {
        Route::post('/upload', [StorageController::class, 'upload'])->name('upload');
        Route::get('/files', [StorageController::class, 'files'])->name('files');
        Route::get('/{id}/url', [StorageController::class, 'url'])->name('url');
        Route::delete('/{id}', [StorageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('integration')->name('integration.')->middleware('role:super_admin')->group(function () {
        Route::post('/webhook', [IntegrationWebhookController::class, 'receive'])->name('webhook');
    });

    Route::prefix('admin/users')->name('admin.users.')->middleware('role:super_admin')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::patch('/{user}/activate', [UserManagementController::class, 'activate'])->name('activate');
        Route::patch('/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('deactivate');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::resource('categories', CategoryController::class)->except('show')->middleware('role:admin,super_admin');
    Route::resource('items', ItemController::class)->except('show')->middleware('role:admin,super_admin');
    Route::resource('customers', CustomerController::class)->middleware('role:admin,super_admin');
    Route::prefix('crm/feedback')->name('crm.feedback.')->middleware('role:admin,super_admin')->group(function () {
        Route::get('/', [CrmFeedbackController::class, 'index'])->name('index');
        Route::patch('/{feedback}', [CrmFeedbackController::class, 'update'])->name('update');
        Route::patch('/{feedback}/resolve', [CrmFeedbackController::class, 'resolve'])->name('resolve');
    });
    Route::get('/customers/{customer}/timeline', [CustomerTimelineController::class, 'show'])->name('customers.timeline')->middleware('role:admin,super_admin');
    Route::post('/customers/{customer}/interactions', [CustomerInteractionController::class, 'store'])->name('customers.interactions.store')->middleware('role:admin,super_admin');
    Route::post('/customers/{customer}/follow-ups', [CustomerFollowUpController::class, 'store'])->name('customers.follow-ups.store')->middleware('role:admin,super_admin');
    Route::put('/follow-ups/{followUp}', [CustomerFollowUpController::class, 'update'])->name('follow-ups.update')->middleware('role:admin,super_admin');
    Route::patch('/follow-ups/{followUp}/complete', [CustomerFollowUpController::class, 'complete'])->name('follow-ups.complete')->middleware('role:admin,super_admin');

    Route::get('/transactions', [StockTransactionController::class, 'index'])->name('transactions.index')->middleware('role:admin,super_admin');
    Route::get('/transactions/{type}/create', [StockTransactionController::class, 'create'])->name('transactions.create')->middleware('role:admin,super_admin');
    Route::post('/transactions', [StockTransactionController::class, 'store'])->name('transactions.store')->middleware('role:admin,super_admin');

    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock')->middleware('role:admin,super_admin');
    Route::get('/reports/stock/pdf', [ReportController::class, 'stockPdf'])->name('reports.stock.pdf')->middleware('role:admin,super_admin');
    Route::get('/reports/transactions/{type}', [ReportController::class, 'transactions'])->name('reports.transactions')->middleware('role:admin,super_admin');
    Route::get('/reports/transactions/{type}/pdf', [ReportController::class, 'transactionsPdf'])->name('reports.transactions.pdf')->middleware('role:admin,super_admin');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales')->middleware('role:admin,super_admin');
    Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf')->middleware('role:admin,super_admin');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments')->middleware('role:admin,super_admin');
    Route::get('/reports/payments/pdf', [ReportController::class, 'paymentsPdf'])->name('reports.payments.pdf')->middleware('role:admin,super_admin');
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue')->middleware('role:admin,super_admin');
    Route::get('/reports/revenue/pdf', [ReportController::class, 'revenuePdf'])->name('reports.revenue.pdf')->middleware('role:admin,super_admin');
    Route::get('/reports/exports', [ReportExportController::class, 'index'])->name('reports.exports.index')->middleware('role:super_admin');
    Route::post('/reports/exports', [ReportExportController::class, 'store'])->name('reports.exports.store')->middleware('role:super_admin');
    Route::get('/reports/exports/{export}', [ReportExportController::class, 'show'])->name('reports.exports.show')->middleware('role:super_admin');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware('role:admin,super_admin');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read')->middleware('role:admin,super_admin');
    Route::get('/notification-preferences', [NotificationPreferenceController::class, 'edit'])->name('notification-preferences.edit');
    Route::put('/notification-preferences', [NotificationPreferenceController::class, 'update'])->name('notification-preferences.update');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('role:admin,super_admin');
    Route::post('/chat', [ChatController::class, 'start'])->name('chat.start')->middleware('role:admin,super_admin');
    Route::get('/chat/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread-count')->middleware('role:admin,super_admin');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show')->middleware('role:admin,super_admin');
    Route::post('/chat/{conversation}', [ChatController::class, 'store'])->name('chat.store')->middleware('role:admin,super_admin');
    Route::post('/chat/{conversation}/read', [ChatController::class, 'markRead'])->name('chat.read')->middleware('role:admin,super_admin');
});
