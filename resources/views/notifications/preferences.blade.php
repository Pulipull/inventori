@extends('layouts.app')

@section('title', 'Preferensi Notifikasi')
@section('actions')
<a href="{{ route('notifications.index') }}" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
@endsection

@section('content')
<section class="rounded-lg bg-white p-5 shadow-sm">
    <form method="post" action="{{ route('notification-preferences.update') }}" class="grid gap-4 text-sm">
        @csrf
        @method('PUT')
        @foreach ([
            'low_stock_enabled' => 'Stok menipis',
            'crm_enabled' => 'CRM',
            'report_enabled' => 'Laporan',
            'system_enabled' => 'Sistem',
        ] as $field => $label)
            <label class="flex items-center justify-between border-b pb-3 last:border-b-0 last:pb-0">
                <span class="font-semibold">{{ $label }}</span>
                <input type="hidden" name="{{ $field }}" value="0">
                <input type="checkbox" name="{{ $field }}" value="1" class="rounded border-gray-300 text-moss" @checked($preferences->{$field})>
            </label>
        @endforeach
        <button class="w-fit rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
    </form>
</section>
@endsection
