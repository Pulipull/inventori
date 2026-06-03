<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'itemCount' => Item::count(),
            'categoryCount' => Category::count(),
            'lowStockCount' => Item::whereColumn('stock', '<=', 'minimum_stock')->where('stock', '>', 0)->count(),
            'emptyStockCount' => Item::where('stock', '<=', 0)->count(),
            'recentTransactions' => StockTransaction::with(['item', 'user'])->latest()->limit(8)->get(),
            'lowItems' => Item::with('category')->whereColumn('stock', '<=', 'minimum_stock')->orderBy('stock')->limit(8)->get(),
        ]);
    }
}
