<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockTransactionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('categories', CategoryController::class)->middleware('role:admin');
    Route::resource('items', ItemController::class);

    Route::get('/transactions', [StockTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{type}/create', [StockTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [StockTransactionController::class, 'store'])->name('transactions.store');

    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/stock/pdf', [ReportController::class, 'stockPdf'])->name('reports.stock.pdf');
    Route::get('/reports/transactions/{type}', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/transactions/{type}/pdf', [ReportController::class, 'transactionsPdf'])->name('reports.transactions.pdf');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'start'])->name('chat.start');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}', [ChatController::class, 'store'])->name('chat.store');
});
