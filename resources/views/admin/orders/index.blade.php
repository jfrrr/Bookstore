@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('page_title', 'Kelola Pesanan')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <span class="hover:text-amber-400 transition-colors">Manajemen Toko</span>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-400">Kelola Pesanan</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight flex items-center gap-3">
                Daftar Pesanan Masuk
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 font-sans">
                    {{ $orders->total() }} Transaksi
                </span>
            </h1>
            <p class="text-sm text-slate-400 max-w-2xl">
                Pantau seluruh siklus pesanan, konfirmasi pesanan COD, proses pengiriman, dan kelola pembaruan status transaksi pelanggan.
            </p>
        </div>
    </div>

    {{-- Metrics Grid --}}
    @php
        $totalOrdersCount = \App\Models\Order::count();
        $pendingOrdersCount = \App\Models\Order::where('status', '!=', 'delivered')->count();
        $deliveredOrdersCount = \App\Models\Order::where('status', 'delivered')->count();
        $completedSalesValue = \App\Models\Order::where('status', 'delivered')->sum('total');
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        {{-- Card 1: Total Pesanan --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Pesanan</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ $totalOrdersCount }}</span>
                        <span class="text-xs text-slate-400">Transaksi</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="text-xs text-slate-400">Semua pesanan masuk</span>
            </div>
        </div>

        {{-- Card 2: Belum Selesai --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Belum Selesai</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-amber-400 font-['Playfair_Display']">{{ $pendingOrdersCount }}</span>
                        <span class="text-xs text-slate-400">Pesanan</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-[22px]">pending_actions</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                @if($pendingOrdersCount > 0)
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-xs text-amber-300 font-medium">Dalam penanganan</span>
                @else
                    <span class="text-xs text-emerald-400">Semua pesanan selesai</span>
                @endif
            </div>
        </div>

        {{-- Card 3: Pesanan Selesai --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Pesanan Selesai</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-emerald-400 font-['Playfair_Display']">{{ $deliveredOrdersCount }}</span>
                        <span class="text-xs text-slate-400">Pesanan</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="text-xs text-emerald-400 font-medium">Transaksi berhasil</span>
            </div>
        </div>

        {{-- Card 4: Penjualan Berhasil --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Omzet Selesai</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-xl lg:text-2xl font-bold text-emerald-400 font-mono">
                            Rp {{ number_format($completedSalesValue, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <span class="material-symbols-outlined text-[22px]">price_check</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="text-xs text-emerald-400 font-medium">Transaksi lunas & delivered</span>
            </div>
        </div>
    </div>

    {{-- Filter Toolbar & Table Stage --}}
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-slate-800 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
                <div class="relative min-w-[280px] flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari No. Pesanan atau Nama Pelanggan..."
                           class="w-full bg-[#020617] border border-slate-700/80 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all">
                </div>

                <select name="status" onchange="this.form.submit()"
                        class="bg-[#020617] border border-slate-700/80 rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-amber-400">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Selesai</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-slate-200 text-sm font-medium transition-colors">
                    Filter
                </button>

                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.orders.index') }}"
                       class="px-3 py-2 rounded-xl bg-slate-800/60 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-xs flex items-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                        <span>Reset</span>
                    </a>
                @endif
            </form>

            <span class="text-xs text-slate-500 shrink-0">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-[#020617]/50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold">
                        <th class="py-4 px-6">No. Pesanan</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Metode Bayar</th>
                        <th class="py-4 px-6 text-right">Total</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-800/40 transition-colors group">
                            {{-- Order Number + Date --}}
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="font-mono font-semibold text-amber-400 hover:text-amber-300 block">
                                    {{ $order->order_number }}
                                </a>
                                <span class="text-xs text-slate-400 mt-0.5 block flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-slate-500">schedule</span>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </span>
                            </td>

                            {{-- Customer --}}
                            <td class="py-4 px-6">
                                <span class="font-semibold text-slate-200 block">{{ $order->customer_name }}</span>
                                <span class="text-xs text-slate-400 block">{{ $order->phone }}</span>
                                @if($order->user)
                                    <span class="text-[11px] text-slate-500 block">{{ $order->user->email }}</span>
                                @endif
                            </td>

                            {{-- Payment Method --}}
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    <span class="material-symbols-outlined text-[14px]">local_shipping</span>
                                    {{ strtoupper($order->payment_method) }}
                                </span>
                            </td>

                            {{-- Total --}}
                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-100">
                                {{ $order->formattedTotal() }}
                            </td>

                            {{-- Status --}}
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $order->statusBadgeClass() }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ !in_array($order->status, ['delivered', 'selesai']) ? 'animate-pulse' : '' }} bg-current"></span>
                                    {{ $order->statusLabel() }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-300 text-xs font-semibold transition-all">
                                    <span>Detail</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-600 mb-2 block">inbox</span>
                                Belum ada pesanan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="p-6 border-t border-slate-800 flex justify-between items-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
