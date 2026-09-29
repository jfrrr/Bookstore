@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-6xl mx-auto px-4 lg:px-8 py-10">
    {{-- Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Akun Saya</span>
            <h1 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-1">Riwayat Pesanan Saya</h1>
            <p class="text-sm text-[#887364] mt-1">Pantau status pemrosesan dan pengiriman buku yang Anda pesan.</p>
        </div>
        <a href="{{ route('books.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#f6ece6] hover:bg-[#ffdcc3] text-[#8d4b00] font-semibold text-sm transition-colors self-start sm:self-auto">
            <span class="material-symbols-outlined text-[18px]">explore</span>
            <span>Jelajahi Buku Lain</span>
        </a>
    </div>

    {{-- Order List --}}
    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-[#e7e5e4] overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    {{-- Card Header --}}
                    <div class="bg-[#fcf2eb] px-6 py-4 border-b border-[#e7e5e4] flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-4">
                            <div>
                                <span class="text-[11px] text-[#887364] uppercase tracking-wider block">No. Pesanan</span>
                                <span class="font-mono font-bold text-[#8d4b00] text-sm sm:text-base">{{ $order->order_number }}</span>
                            </div>
                            <span class="text-slate-300 hidden sm:inline">|</span>
                            <div class="hidden sm:block">
                                <span class="text-[11px] text-[#887364] uppercase tracking-wider block">Tanggal Transaksi</span>
                                <span class="text-xs text-[#554336] font-medium">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $order->statusBadgeClass() }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ !in_array($order->status, ['delivered', 'selesai']) ? 'animate-pulse' : '' }} bg-current"></span>
                                {{ $order->statusLabel() }}
                            </span>
                        </div>
                    </div>

                    {{-- Items List --}}
                    <div class="p-6 divide-y divide-[#f0e6e0]">
                        @foreach($order->items as $item)
                            <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-14 rounded-lg bg-[#f6ece6] border border-[#e7e5e4] flex items-center justify-center shrink-0 overflow-hidden shadow-xs">
                                        @if($item->book && $item->book->cover_image)
                                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-[#8d4b00]/30 text-xl">menu_book</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-sm text-[#1f1b17] line-clamp-1">{{ $item->book_title }}</p>
                                        <p class="text-xs text-[#887364] mt-0.5">{{ $item->author }} · {{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="font-bold text-sm text-[#8d4b00] tabular-nums shrink-0">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Card Footer --}}
                    <div class="bg-[#fff8f5] px-6 py-4 border-t border-[#e7e5e4] flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <span class="text-xs text-[#887364]">Total Pembayaran (COD):</span>
                            <span class="text-base font-bold text-[#8d4b00] tabular-nums ml-1">{{ $order->formattedTotal() }}</span>
                        </div>
                        <a href="{{ route('orders.show', $order) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#8d4b00] hover:bg-[#6e3900] text-white text-xs font-semibold transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                            <span>Detail Pesanan</span>
                            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="pt-4 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-16 bg-white rounded-2xl border border-[#e7e5e4] p-8 max-w-lg mx-auto">
            <div class="w-20 h-20 rounded-full bg-[#f6ece6] flex items-center justify-center mx-auto mb-4 text-[#8d4b00]">
                <span class="material-symbols-outlined text-4xl">receipt_long</span>
            </div>
            <h2 class="font-['Playfair_Display'] font-bold text-xl text-[#1f1b17] mb-2">Belum Ada Pesanan</h2>
            <p class="text-sm text-[#887364] max-w-sm mx-auto mb-6">
                Anda belum pernah melakukan pemesanan buku. Temukan buku favorit Anda dan checkout dengan mudah menggunakan pembayaran COD.
            </p>
            <a href="{{ route('books.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#8d4b00] hover:bg-[#6e3900] text-white font-semibold text-sm transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                <span>Mulai Belanja Buku</span>
            </a>
        </div>
    @endif
</div>
@endsection
