@extends('layouts.app')

@section('title', 'Dashboard Pembeli')

@section('actions')
    <a href="{{ route('checkout.index') }}" class="inline-block rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">
        Checkout Manual
    </a>
@endsection

@section('content')
    <div class="grid gap-4 sm:grid-cols-3">
        <x-dashboard.stat-card label="Total Pesanan" :value="(int) ($orderSummary->total ?? 0)" hint="Semua transaksi" tone="blue" />
        <x-dashboard.stat-card label="Berhasil" :value="(int) ($orderSummary->paid ?? 0)" hint="Pembayaran lunas" tone="green" />
        <x-dashboard.stat-card label="Menunggu" :value="(int) ($orderSummary->pending ?? 0)" hint="Pending payment" tone="amber" />
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_0.95fr]">
        <x-dashboard.panel title="Barang Tersedia" description="Katalog pilihan untuk checkout cepat">
            <x-slot:actions>
                <a href="{{ route('checkout.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Pesan manual</a>
            </x-slot:actions>

            <div class="grid gap-4 sm:grid-cols-2">
                @forelse ($items as $item)
                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm shadow-gray-200/60">
                        <div class="aspect-[4/3] bg-gray-100">
                            @if ($item->media_url && $item->media_type !== 'video')
                                <img src="{{ $item->media_url }}" alt="{{ $item->name }}" class="h-full w-full object-cover" loading="lazy">
                            @else
                                <div class="grid h-full place-items-center px-3 text-center text-sm font-semibold text-gray-500">
                                    {{ $item->category->name ?? 'Barang' }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate font-semibold text-gray-950">{{ $item->name }}</h3>
                                    <p class="mt-1 truncate text-xs text-gray-500">{{ $item->code }} &middot; {{ $item->category->name ?? '-' }}</p>
                                </div>
                                <span class="shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">{{ $item->stock }}</span>
                            </div>
                            <p class="mt-3 text-lg font-semibold text-gray-950">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-gray-500">{{ $item->description ?: 'Barang siap dipesan.' }}</p>
                            <a
                                href="{{ route('checkout.index', ['item_id' => $item->id, 'description' => 'Pesanan '.$item->name]) }}"
                                class="mt-4 block rounded-xl bg-gray-950 px-3 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Pesan
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500 sm:col-span-2">
                        Belum ada barang tersedia untuk dipesan.
                    </div>
                @endforelse
            </div>
        </x-dashboard.panel>

        <x-dashboard.panel id="order-history" title="Recent Orders" description="Riwayat pembayaran dan invoice">
            @if ($orders->isEmpty())
                <div class="rounded-xl bg-gray-50 p-8 text-center">
                    <h3 class="font-semibold text-gray-950">Belum ada pesanan</h3>
                    <p class="mt-1 text-sm text-gray-500">Pilih barang dari katalog untuk membuat pesanan pertama.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-semibold uppercase tracking-normal text-gray-400">
                                <th class="pb-3">Invoice</th>
                                <th class="pb-3">Barang</th>
                                <th class="pb-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="py-3 pr-3">
                                        <p class="font-mono text-sm font-semibold text-gray-950">{{ $order->invoice_number }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                    </td>
                                    <td class="py-3 pr-3">
                                        <p class="max-w-48 truncate text-sm font-medium text-gray-800">{{ $order->item?->name ?? $order->description ?? '-' }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="py-3 text-right">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                            @if ($order->status === 'paid')
                                                bg-emerald-50 text-emerald-700
                                            @elseif ($order->status === 'pending')
                                                bg-amber-50 text-amber-700
                                            @elseif ($order->status === 'failed')
                                                bg-rose-50 text-rose-700
                                            @else
                                                bg-gray-100 text-gray-700
                                            @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        @if ($order->status === 'pending' && $order->payment_url)
                                            <a href="{{ $order->payment_url }}" class="mt-2 block text-xs font-semibold text-blue-700 hover:text-blue-800">Bayar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif
        </x-dashboard.panel>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <x-dashboard.panel title="Feedback" description="Status aftersales terbaru">
            <x-slot:actions>
                <a href="{{ route('feedback.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat semua</a>
            </x-slot:actions>

            <div class="space-y-1">
                @forelse ($feedbacks as $feedback)
                    <x-dashboard.status-row
                        :label="$feedback->title"
                        :value="ucfirst($feedback->status)"
                        :meta="'Rating '.$feedback->rating.'/5 - '.ucfirst($feedback->category)"
                        :tone="$feedback->status === 'resolved' ? 'green' : ($feedback->status === 'reviewed' ? 'blue' : 'amber')"
                    />
                @empty
                    <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                        Belum ada feedback. Kirim feedback untuk layanan aftersales.
                    </div>
                @endforelse
            </div>

            <a href="{{ route('feedback.create') }}" class="mt-4 block rounded-xl bg-gray-950 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">Kirim Feedback</a>
        </x-dashboard.panel>

        <x-dashboard.panel title="Recent Notifications" description="Informasi akun dan pesanan">
            <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                Notifikasi pembeli akan tampil mengikuti data yang sudah tersedia di aplikasi.
            </div>
        </x-dashboard.panel>

        <x-dashboard.panel title="Recent Chat" description="Komunikasi terkait layanan">
            <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                Percakapan pembeli mengikuti akses chat yang sudah diatur oleh aplikasi.
            </div>
        </x-dashboard.panel>
    </div>
@endsection
