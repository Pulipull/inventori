@extends('layouts.app')

@section('title', 'CRM Customer')
@section('actions')
<a href="{{ route('customers.create') }}" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Tambah Customer</a>
@endsection

@section('content')
<form class="mb-4 grid gap-2 md:grid-cols-[1fr_180px_auto]">
    <input name="search" value="{{ request('search') }}" placeholder="Cari nama, email, telepon, atau perusahaan" class="rounded border-gray-300">
    <select name="status" class="rounded border-gray-300">
        <option value="">Semua Status</option>
        <option value="active" @selected(request('status') === 'active')>Aktif</option>
        <option value="inactive" @selected(request('status') === 'inactive')>Tidak Aktif</option>
    </select>
    <button class="rounded bg-ink px-4 py-2 text-white">Cari</button>
</form>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Nama</th><th class="p-4">Kontak</th><th class="p-4">Perusahaan</th><th class="p-4">Source</th><th class="p-4">Status</th><th class="p-4"></th></tr>
        </thead>
        <tbody>
        @forelse ($customers as $customer)
            <tr class="border-t">
                <td class="p-4">
                    <a href="{{ route('customers.show', $customer) }}" class="font-semibold text-moss">{{ $customer->name }}</a>
                    @if ($customer->external_customer_id)
                        <p class="text-xs text-gray-400">{{ $customer->external_customer_id }}</p>
                    @endif
                </td>
                <td class="p-4">
                    <p>{{ $customer->email ?: '-' }}</p>
                    <p class="text-xs text-gray-500">{{ $customer->phone ?: '-' }}</p>
                </td>
                <td class="p-4">{{ $customer->company ?: '-' }}</td>
                <td class="p-4">{{ $customer->source }}</td>
                <td class="p-4"><span class="rounded px-2 py-1 text-xs {{ $customer->status === 'active' ? 'bg-moss/10 text-moss' : 'bg-gray-100 text-gray-500' }}">{{ $customer->status }}</span></td>
                <td class="p-4 text-right">
                    <a href="{{ route('customers.edit', $customer) }}" class="text-moss">Edit</a>
                    <form method="post" action="{{ route('customers.destroy', $customer) }}" class="inline" onsubmit="return confirm('Hapus customer?')">
                        @csrf @method('DELETE')
                        <button class="ml-3 text-coral">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-4 text-center text-sm text-gray-500">Belum ada customer.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $customers->links() }}</div>
</div>
@endsection
