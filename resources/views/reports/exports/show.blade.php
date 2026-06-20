@extends('layouts.app')

@section('title', 'Detail Export Laporan')
@section('actions')
<a href="{{ route('reports.exports.index') }}" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
@endsection

@section('content')
<div class="rounded-lg bg-white p-5 shadow-sm">
    <div class="grid gap-4 text-sm md:grid-cols-2">
        <div><p class="text-gray-500">Jenis Laporan</p><p class="font-semibold">{{ $export->report_type }}</p></div>
        <div><p class="text-gray-500">Status</p><p class="font-semibold">{{ $export->status }}</p></div>
        <div><p class="text-gray-500">Pemohon</p><p class="font-semibold">{{ $export->user->name }}</p></div>
        <div><p class="text-gray-500">Generated At</p><p class="font-semibold">{{ $export->generated_at?->format('d M Y H:i') ?: '-' }}</p></div>
    </div>

    <div class="mt-5 border-t pt-5">
        <p class="mb-2 text-sm text-gray-500">Filter</p>
        <pre class="overflow-auto rounded bg-gray-50 p-3 text-xs">{{ json_encode($metadata['filters'], JSON_PRETTY_PRINT) }}</pre>
    </div>

    @if ($export->file_path)
        <div class="mt-5 border-t pt-5">
            <p class="mb-2 text-sm text-gray-500">File Reference</p>
            <a href="{{ $export->file_path }}" class="text-moss">{{ $export->file_path }}</a>
        </div>
    @endif
</div>
@endsection
