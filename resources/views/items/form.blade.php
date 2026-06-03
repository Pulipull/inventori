@extends('layouts.app')

@section('title', $item->exists ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<form method="post" action="{{ $item->exists ? route('items.update', $item) : route('items.store') }}" class="max-w-3xl rounded-lg bg-white p-6 shadow-sm">
    @csrf
    @if ($item->exists) @method('PUT') @endif
    <div class="grid gap-4 md:grid-cols-2">
        <label class="block text-sm font-medium">Kategori
            <select name="category_id" required class="mt-1 w-full rounded border-gray-300">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-medium">Kode
            <input name="code" value="{{ old('code', $item->code) }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Nama
            <input name="name" value="{{ old('name', $item->name) }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Satuan
            <input name="unit" value="{{ old('unit', $item->unit ?? 'pcs') }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Stok Awal
            <input name="stock" type="number" min="0" value="{{ old('stock', $item->stock ?? 0) }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Stok Minimum
            <input name="minimum_stock" type="number" min="0" value="{{ old('minimum_stock', $item->minimum_stock ?? 5) }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
    </div>
    <label class="mt-4 block text-sm font-medium">Deskripsi
        <textarea name="description" rows="4" class="mt-1 w-full rounded border-gray-300">{{ old('description', $item->description) }}</textarea>
    </label>
    <button class="mt-6 rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
</form>
@endsection
