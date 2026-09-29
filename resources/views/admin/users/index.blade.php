@extends('layouts.admin')
@section('title', 'Daftar Pelanggan')
@section('page_title', 'Pelanggan')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <span class="hover:text-amber-400 transition-colors">Pelanggan</span>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-400">Daftar Pelanggan</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight flex items-center gap-3">
                Pelanggan Terdaftar
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 font-sans">
                    {{ $users->total() }} Pelanggan
                </span>
            </h1>
            <p class="text-sm text-slate-400 max-w-2xl">
                Pantau daftar akun pelanggan yang terdaftar di toko online BookStore beserta histori jumlah transaksi pesanan mereka.
            </p>
        </div>
    </div>

    {{-- Metrics Grid --}}
    @php
        $totalCustomers = \App\Models\User::where('role', 'user')->count();
    @endphp
    <div class="max-w-md">
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Pelanggan Terdaftar</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ $totalCustomers }}</span>
                        <span class="text-xs text-slate-400">Pengguna</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs text-emerald-400 font-medium">Akun pelanggan aktif</span>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <span class="text-sm font-semibold text-slate-200">Daftar Akun Pelanggan</span>
            <span class="text-xs text-slate-500">Menampilkan {{ $users->count() }} dari {{ $users->total() }} pelanggan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-[#020617]/50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold">
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Terdaftar Sejak</th>
                        <th class="py-4 px-6 text-center">Total Pesanan</th>
                        <th class="py-4 px-6 text-center">Peran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm">
                    @forelse($users as $customer)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 font-bold shrink-0">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-200 block">{{ $customer->name }}</span>
                                        <span class="text-xs text-slate-500 font-mono">ID: #USR-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-300 font-mono text-xs">
                                {{ $customer->email }}
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-xs">
                                {{ $customer->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $customer->orders_count > 0 ? 'bg-amber-500/10 text-amber-300 border border-amber-500/20' : 'bg-slate-800 text-slate-500' }}">
                                    {{ $customer->orders_count }} Transaksi
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                    Customer
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-600 mb-2 block">group_off</span>
                                Belum ada pelanggan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-6 border-t border-slate-800 flex justify-between items-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
