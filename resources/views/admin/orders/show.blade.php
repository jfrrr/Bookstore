@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->order_number)
@section('page_title', 'Detail Pesanan')

@push('head')
<style>
@media print {
    aside, header, #flash-container, .no-print {
        display: none !important;
    }
    body {
        background: white !important;
        color: black !important;
    }
    .pl-64 {
        padding-left: 0 !important;
    }
}
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Top Breadcrumb & Actions --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="space-y-1.5">
            <nav class="flex items-center gap-2 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-amber-400 transition-colors">Kelola Pesanan</a>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-300 font-mono">#{{ $order->order_number }}</span>
            </nav>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl lg:text-3xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight">
                    Pesanan #{{ $order->order_number }}
                </h1>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $order->statusBadgeClass() }}">
                    <span class="w-2 h-2 rounded-full {{ !in_array($order->status, ['delivered', 'selesai']) ? 'animate-ping' : '' }} bg-current"></span>
                    {{ $order->statusLabel() }}
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/20 text-xs font-semibold">
                    <span class="material-symbols-outlined text-[15px]">payments</span>
                    Metode: {{ strtoupper($order->payment_method) }}
                </span>
            </div>
            <p class="text-xs text-slate-400 flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-slate-500">schedule</span>
                Dipesan pada <span class="text-slate-200 font-medium">{{ $order->created_at->format('d F Y, H:i') }} WIB</span>
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3">
            @if(count($allowedTransitions) > 0)
                <button onclick="toggleModal('updateStatusModal')"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition-all">
                    <span class="material-symbols-outlined text-[18px]">sync_alt</span>
                    <span>Perbarui Status Pesanan</span>
                </button>
            @endif
        </div>
    </div>

    {{-- Order Lifecycle 2-Step Progress Tracker --}}
    @php
        $isDelivered = in_array($order->status, ['delivered', 'selesai']);
    @endphp
    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-amber-400 text-[22px]">route</span>
                <h2 class="text-base font-bold text-slate-100">Status Alur Pesanan</h2>
            </div>
            <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $order->statusBadgeClass() }}">
                {{ $order->statusLabel() }}
            </span>
        </div>

        <div class="relative flex flex-col sm:flex-row items-center justify-center gap-8 max-w-xl mx-auto">
            {{-- Step 1: Belum Selesai --}}
            <div class="flex-1 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sm mb-2 transition-all
                    {{ $isDelivered ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500 text-slate-950 shadow-lg shadow-amber-500/30 ring-4 ring-amber-500/20' }}">
                    <span class="material-symbols-outlined text-[22px]">{{ $isDelivered ? 'check' : 'pending_actions' }}</span>
                </div>
                <span class="text-xs font-semibold {{ $isDelivered ? 'text-emerald-400' : 'text-amber-400' }}">
                    Belum Selesai (Proses)
                </span>
            </div>

            {{-- Arrow / Divider --}}
            <div class="hidden sm:block text-slate-600">
                <span class="material-symbols-outlined text-2xl">arrow_forward</span>
            </div>

            {{-- Step 2: Selesai --}}
            <div class="flex-1 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sm mb-2 transition-all
                    {{ $isDelivered ? 'bg-emerald-500 text-slate-950 shadow-lg shadow-emerald-500/30 ring-4 ring-emerald-500/20' : 'bg-slate-800/80 text-slate-500 border border-slate-700/50' }}">
                    <span class="material-symbols-outlined text-[22px]">task_alt</span>
                </div>
                <span class="text-xs font-semibold {{ $isDelivered ? 'text-emerald-400 font-bold' : 'text-slate-500' }}">
                    Selesai
                </span>
            </div>
        </div>
    </div>

    {{-- Main Grid: Items & Customer Details --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Order Items & Pricing Table (2 Cols) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-amber-400 text-[20px]">menu_book</span>
                        <h3 class="text-base font-bold text-slate-100">Item Buku yang Dipesan</h3>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700">
                        {{ $order->items->sum('quantity') }} Total Buku
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-800 bg-[#020617]/50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold">
                                <th class="py-3 px-6">Buku</th>
                                <th class="py-3 px-4 text-right">Harga</th>
                                <th class="py-3 px-4 text-center">Jumlah</th>
                                <th class="py-3 px-6 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-14 rounded-lg bg-slate-800 border border-slate-700 overflow-hidden shrink-0 shadow">
                                                @if($item->book && $item->book->cover_image)
                                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-600">
                                                        <span class="material-symbols-outlined text-[18px]">book</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-semibold text-slate-200 block line-clamp-1">{{ $item->title }}</span>
                                                @if($item->book)
                                                    <span class="text-xs text-slate-400 block">Penulis: {{ $item->book->author }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-right font-mono text-slate-300 text-xs">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center font-semibold text-slate-200">
                                        {{ $item->quantity }}x
                                    </td>
                                    <td class="py-4 px-6 text-right font-mono font-bold text-slate-100">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Summary Footer --}}
                <div class="p-6 bg-[#020617]/60 border-t border-slate-800 space-y-2">
                    <div class="flex justify-between text-xs text-slate-400">
                        <span>Subtotal Produk</span>
                        <span class="font-mono text-slate-200">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-slate-400">
                        <span>Biaya Pengiriman (COD Express)</span>
                        <span class="font-mono text-emerald-400 font-semibold">GRATIS</span>
                    </div>
                    <div class="pt-3 border-t border-slate-800 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-slate-200">Total Pembayaran COD</span>
                        <span class="text-xl font-bold font-mono text-amber-400">{{ $order->formattedTotal() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Customer & Shipping Details (1 Col) --}}
        <div class="space-y-6">
            {{-- Customer Card --}}
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-800">
                    <span class="material-symbols-outlined text-amber-400 text-[20px]">person</span>
                    <h3 class="text-base font-bold text-slate-100">Informasi Pemesan</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider block">Nama Penerima</span>
                        <span class="font-semibold text-slate-200 block">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider block">Nomor Telepon / WhatsApp</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank"
                           class="font-mono text-amber-400 hover:underline flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[16px]">chat</span>
                            {{ $order->phone }}
                        </a>
                    </div>
                    @if($order->user)
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block">Akun Terdaftar</span>
                            <span class="text-slate-300 block">{{ $order->user->email }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Shipping Address Card --}}
            <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-800">
                    <span class="material-symbols-outlined text-amber-400 text-[20px]">local_shipping</span>
                    <h3 class="text-base font-bold text-slate-100">Alamat Pengiriman</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider block">Alamat Tujuan</span>
                        <p class="text-slate-300 leading-relaxed mt-1 p-3 rounded-xl bg-[#020617] border border-slate-800">
                            {{ $order->delivery_address }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider block">Metode Pembayaran</span>
                        <div class="mt-1 flex items-center gap-2 text-slate-300">
                            <span class="material-symbols-outlined text-amber-400 text-[18px]">verified</span>
                            <span>Bayar di Tempat (COD)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Update Status Pesanan (Matching Reference Modal) --}}
@if(count($allowedTransitions) > 0)
<div id="updateStatusModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-amber-400">edit_note</span>
                <h3 class="text-lg font-bold text-slate-100">Perbarui Status Pesanan</h3>
            </div>
            <button onclick="toggleModal('updateStatusModal')" class="p-1 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Status Baru</label>
                <select name="status" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20">
                    <option value="pending" {{ !in_array($order->status, ['delivered', 'selesai']) ? 'selected' : '' }}>
                        Belum Selesai
                    </option>
                    <option value="delivered" {{ in_array($order->status, ['delivered', 'selesai']) ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <button type="button" onclick="toggleModal('updateStatusModal')"
                        class="px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm transition-all shadow-lg shadow-amber-500/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}
</script>
@endif
@endsection
