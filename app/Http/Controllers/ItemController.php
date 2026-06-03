<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $items = Item::with('category')
            ->when($request->search, fn ($query, $search) => $query->where(fn ($nested) => $nested->where('name', 'ilike', "%{$search}%")->orWhere('code', 'ilike', "%{$search}%")))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('items.index', compact('items'));
    }

    public function create(): View
    {
        return view('items.form', ['item' => new Item(), 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Item::create($this->validated($request));

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item): View
    {
        return view('items.form', ['item' => $item, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $item->update($this->validated($request, $item));

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return back()->with('success', 'Barang berhasil dihapus.');
    }

    private function validated(Request $request, ?Item $item = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:100', 'unique:items,code,'.($item?->id ?? 'NULL')],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
