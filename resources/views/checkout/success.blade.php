@extends('layouts.app')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    {{-- Success Animation --}}
    <div class="text-center mb-10">
        <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-5">
            <span class="material-symbols-outlined text-4xl text-emerald-600" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <h1 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17]">Pesanan Berhasil Dibuat!</h1>
        <p class="text-[#887364] mt-2">Terima kasih telah berbelanja di BookStore. Pesanan Anda sedang diproses.</p>
    </div>

    {{-- Order Details Card --}}
    <div class="bg-white rounded-2xl border border-[#e7e5e4] overflow-hidden shadow-sm">
        {{-- Order Header --}}
        <div class="bg-[#f6ece6] px-6 py-5 border-b border-[#e7e5e4] flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs text-[#887364] uppercase tracking-widest mb-1">Nomor Pesanan</p>
                <p class="font-bold text-xl text-[#8d4b00] font-mono">{{ $order->order_number }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-[#887364] uppercase tracking-widest mb-1">Status</p>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/10 text-amber-700 border border-amber-500/20 text-sm font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $order->statusLabel() }}
                </span>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-4 border-b border-[#e7e5e4]">
            <div>
                <p class="text-xs text-[#887364] uppercase tracking-widest mb-1">Penerima</p>
                <p class="font-semibold text-[#1f1b17]">{{ $order->customer_name }}</p>
                <p class="text-sm text-[#554336]">{{ $order->phone }}</p>
            </div>
            <div>
                <p class="text-xs text-[#887364] uppercase tracking-widest mb-1">Alamat Pengiriman</p>
                <p class="text-sm text-[#554336] leading-relaxed">{{ $order->delivery_address }}</p>
            </div>
            <div>
                <p class="text-xs text-[#887364] uppercase tracking-widest mb-1">Pembayaran</p>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-base text-[#8d4b00]" style="font-variation-settings: 'FILL' 1;">payments</span>
                    <span class="font-medium text-[#1f1b17]">Bayar di Tempat (COD)</span>
                </div>
            </div>
            <div>
                <p class="text-xs text-[#887364] uppercase tracking-widest mb-1">Tanggal Pesanan</p>
                <p class="font-medium text-[#1f1b17]">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="px-6 py-5 border-b border-[#e7e5e4]">
            <h3 class="font-semibold text-[#1f1b17] mb-4">Buku yang Dipesan</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-14 rounded-lg bg-[#f6ece6] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl text-[#8d4b00]/40" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-[#1f1b17] line-clamp-1">{{ $item->book_title }}</p>
                        <p class="text-xs text-[#887364]">{{ $item->author }} · ×{{ $item->quantity }}</p>
                    </div>
                    <span class="font-semibold text-[#8d4b00] text-sm tabular-nums">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Total --}}
        <div class="px-6 py-5 flex items-center justify-between">
            <span class="font-bold text-[#1f1b17]">Total Pembayaran</span>
            <span class="font-bold text-2xl text-[#8d4b00] tabular-nums">{{ $order->formattedTotal() }}</span>
        </div>
    </div>

    {{-- Notice --}}
    <div class="mt-6 bg-[#fffbeb] border border-[#fef3c7] rounded-2xl p-5 flex items-start gap-4">
        <span class="material-symbols-outlined text-amber-500 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
        <div>
            <p class="font-semibold text-[#b45309] text-sm">Informasi Pembayaran</p>
            <p class="text-[#92400e] text-sm mt-1">
                Siapkan uang tunai sebesar <strong>{{ $order->formattedTotal() }}</strong> untuk diberikan kepada kurir saat paket tiba di alamat Anda.
            </p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-wrap gap-4 mt-8 justify-center">
        <a href="{{ route('orders.show', $order) }}"
           class="flex items-center gap-2 bg-[#8d4b00] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#6e3900] transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px]">visibility</span>
            Lihat Status Pesanan
        </a>
        <a href="{{ route('books.index') }}"
           class="flex items-center gap-2 border border-[#dbc2b0] text-[#554336] font-medium px-6 py-3 rounded-xl hover:bg-[#f6ece6] transition-colors">
            <span class="material-symbols-outlined text-[20px]">explore</span>
            Lanjut Belanja
        </a>
    </div>
</div>
@endsection
