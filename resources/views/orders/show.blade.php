@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 lg:px-8 py-10 space-y-8">
    {{-- Breadcrumb & Header --}}
    <div class="space-y-2">
        <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#887364]">
            <a href="{{ route('orders.index') }}" class="hover:text-[#8d4b00] transition-colors">Pesanan Saya</a>
            <span class="material-symbols-outlined text-[14px] text-slate-400">chevron_right</span>
            <span class="text-[#8d4b00] font-mono">#{{ $order->order_number }}</span>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-['Playfair_Display'] font-bold text-2xl sm:text-3xl text-[#1f1b17]">
                    Detail Pesanan #{{ $order->order_number }}
                </h1>
                <p class="text-sm text-[#887364] mt-1">
                    Dipesan pada {{ $order->created_at->format('d F Y, H:i') }} WIB
                </p>
            </div>
            <div class="self-start sm:self-auto flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold border {{ $order->statusBadgeClass() }}">
                    <span class="w-2 h-2 rounded-full {{ !in_array($order->status, ['delivered', 'selesai']) ? 'animate-ping' : '' }} bg-current"></span>
                    {{ $order->statusLabel() }}
                </span>
            </div>
        </div>
    </div>

    {{-- Status Pesanan --}}
    @php
        $isDelivered = in_array($order->status, ['delivered', 'selesai']);
    @endphp
    <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 {{ $isDelivered ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                <span class="material-symbols-outlined text-2xl">{{ $isDelivered ? 'check_circle' : 'schedule' }}</span>
            </div>
            <div>
                <span class="text-xs text-[#887364] uppercase tracking-wider block font-semibold">Status Pesanan</span>
                <p class="text-lg font-bold {{ $isDelivered ? 'text-emerald-700' : 'text-amber-700' }}">
                    {{ $order->statusLabel() }}
                </p>
                <p class="text-xs text-[#887364] mt-0.5">
                    {{ $isDelivered ? 'Pesanan telah selesai dan barang telah berhasil diterima.' : 'Pesanan Anda saat ini sedang diproses oleh toko kami.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Shipping & Delivery Info --}}
        <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6 shadow-sm space-y-4">
            <h3 class="font-semibold text-base text-[#1f1b17] flex items-center gap-2 pb-3 border-b border-[#e7e5e4]">
                <span class="material-symbols-outlined text-[#8d4b00]">local_shipping</span>
                <span>Informasi Pengiriman</span>
            </h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-[#887364] uppercase tracking-wider block">Penerima</span>
                    <span class="font-medium text-[#1f1b17]">{{ $order->customer_name }}</span>
                    <span class="text-[#887364] block text-xs">{{ $order->phone }}</span>
                </div>
                <div>
                    <span class="text-xs text-[#887364] uppercase tracking-wider block">Alamat Tujuan</span>
                    <p class="text-[#554336] mt-1 p-3 rounded-xl bg-[#fff8f5] border border-[#e7e5e4] leading-relaxed text-xs">
                        {{ $order->delivery_address }}
                    </p>
                </div>
                <div>
                    <span class="text-xs text-[#887364] uppercase tracking-wider block">Metode Pembayaran</span>
                    <div class="flex items-center gap-2 mt-1 text-[#1f1b17] font-medium">
                        <span class="material-symbols-outlined text-[#8d4b00] text-[18px]">payments</span>
                        <span>Bayar di Tempat (COD)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items Summary --}}
        <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6 shadow-sm space-y-4">
            <h3 class="font-semibold text-base text-[#1f1b17] flex items-center gap-2 pb-3 border-b border-[#e7e5e4]">
                <span class="material-symbols-outlined text-[#8d4b00]">menu_book</span>
                <span>Rincian Buku</span>
            </h3>
            <div class="space-y-3 max-h-56 overflow-y-auto pr-1">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between gap-3 text-sm">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="text-xs font-bold text-[#8d4b00] bg-[#f6ece6] px-2 py-1 rounded-md shrink-0">
                                {{ $item->quantity }}x
                            </span>
                            <div class="min-w-0">
                                <p class="font-medium text-[#1f1b17] truncate">{{ $item->book_title }}</p>
                                <p class="text-[11px] text-[#887364]">{{ $item->author }}</p>
                            </div>
                        </div>
                        <span class="font-semibold text-xs text-[#554336] tabular-nums shrink-0">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-[#e7e5e4] space-y-1.5 text-xs">
                <div class="flex justify-between text-[#887364]">
                    <span>Ongkos Kirim COD</span>
                    <span class="text-emerald-600 font-semibold uppercase">Gratis</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-[#1f1b17] pt-2 border-t border-[#e7e5e4]">
                    <span>Total yang Harus Dibayar:</span>
                    <span class="text-[#8d4b00] font-mono text-base">{{ $order->formattedTotal() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Action --}}
    <div class="flex justify-center pt-2">
        <a href="{{ route('orders.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#f6ece6] hover:bg-[#ffdcc3] text-[#8d4b00] font-semibold text-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Riwayat Pesanan</span>
        </a>
    </div>
</div>
@endsection
