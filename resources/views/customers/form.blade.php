@extends('layouts.app')

@section('title', $customer->exists ? 'Edit Customer' : 'Tambah Customer')

@section('content')
<form method="post" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}" class="max-w-3xl rounded-lg bg-white p-6 shadow-sm">
    @csrf
    @if ($customer->exists) @method('PUT') @endif

    <div class="grid gap-4 md:grid-cols-2">
        <label class="block text-sm font-medium">Nama
            <input name="name" value="{{ old('name', $customer->name) }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Email
            <input name="email" type="email" value="{{ old('email', $customer->email) }}" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Telepon
            <input name="phone" value="{{ old('phone', $customer->phone) }}" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Perusahaan
            <input name="company" value="{{ old('company', $customer->company) }}" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Source
            <input name="source" value="{{ old('source', $customer->source ?? 'manual') }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">External Customer ID
            <input name="external_customer_id" value="{{ old('external_customer_id', $customer->external_customer_id) }}" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">User Terkait
            <select name="user_id" class="mt-1 w-full rounded border-gray-300">
                <option value="">Tidak terhubung</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $customer->user_id) == $user->id)>{{ $user->name }} - {{ $user->email }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-medium">Status
            <select name="status" required class="mt-1 w-full rounded border-gray-300">
                <option value="active" @selected(old('status', $customer->status ?? 'active') === 'active')>Aktif</option>
                <option value="inactive" @selected(old('status', $customer->status) === 'inactive')>Tidak Aktif</option>
            </select>
        </label>
    </div>

    <label class="mt-4 block text-sm font-medium">Catatan
        <textarea name="notes" rows="4" class="mt-1 w-full rounded border-gray-300">{{ old('notes', $customer->notes) }}</textarea>
    </label>

    <div class="mt-6 flex gap-2">
        <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
        <a href="{{ $customer->exists ? route('customers.show', $customer) : route('customers.index') }}" class="rounded bg-gray-100 px-4 py-2 font-semibold text-gray-600">Batal</a>
    </div>
</form>
@endsection
