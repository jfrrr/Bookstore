@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

{{-- Stats Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['menu_book', 'Total Buku', $stats['total_books'], 'admin.books.index', 'text-sky-400', 'bg-sky-500/10'],
        ['folder', 'Kategori', $stats['total_categories'], 'admin.categories.index', 'text-violet-400', 'bg-violet-500/10'],
        ['group', 'Pelanggan', $stats['total_users'], 'admin.users.index', 'text-emerald-400', 'bg-emerald-500/10'],
        ['shopping_bag', 'Total Pesanan', $stats['total_orders'], 'admin.orders.index', 'text-amber-400', 'bg-amber-500/10'],
    ] as [$icon, $label, $value, $route, $iconColor, $bgColor])
    <a href="{{ route($route) }}" class="bg-slate-900 rounded-2xl p-5 border border-slate-800 hover:border-slate-700 transition-colors group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl {{ $bgColor }} flex items-center justify-center">
                <span class="material-symbols-outlined {{ $iconColor }} text-xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
            </div>
            <span class="material-symbols-outlined text-slate-700 group-hover:text-slate-500 text-base transition-colors">arrow_forward</span>
        </div>
        <p class="text-3xl font-bold text-slate-100 tabular-nums">{{ number_format($value) }}</p>
        <p class="text-sm text-slate-500 mt-1">{{ $label }}</p>
    </a>
    @endforeach
</div>

{{-- Secondary Stats Row --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-slate-900 rounded-2xl p-5 border border-slate-800 flex items-center gap-4">
        <span class="material-symbols-outlined text-amber-400 text-2xl" style="font-variation-settings: 'FILL' 1;">pending</span>
        <div>
            <p class="text-2xl font-bold text-slate-100 tabular-nums">{{ $stats['pending_orders'] }}</p>
            <p class="text-sm text-slate-500">Pesanan Belum Selesai</p>
        </div>
    </div>
    <div class="bg-slate-900 rounded-2xl p-5 border border-slate-800 flex items-center gap-4">
        <span class="material-symbols-outlined text-emerald-400 text-2xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <div>
            <p class="text-2xl font-bold text-slate-100 tabular-nums">{{ $stats['delivered_orders'] }}</p>
            <p class="text-sm text-slate-500">Pesanan Selesai</p>
        </div>
    </div>
    <a href="{{ route('admin.messages.index') }}" class="bg-slate-900 rounded-2xl p-5 border border-slate-800 hover:border-slate-700 transition-colors flex items-center justify-between group">
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-sky-400 text-2xl" style="font-variation-settings: 'FILL' 1;">mail</span>
            <div>
                <div class="flex items-baseline gap-2">
                    <p class="text-2xl font-bold text-slate-100 tabular-nums">{{ $stats['total_messages'] }}</p>
                    @if($stats['unread_messages'] > 0)
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30">
                            {{ $stats['unread_messages'] }} baru
                        </span>
                    @endif
                </div>
                <p class="text-sm text-slate-500">Pesan Kontak Masuk</p>
            </div>
        </div>
        <span class="material-symbols-outlined text-slate-700 group-hover:text-slate-500 text-base transition-colors">arrow_forward</span>
    </a>
</div>

{{-- Main Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- Recent Orders --}}
    <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
            <h3 class="font-semibold text-slate-100">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-amber-400 hover:text-amber-300 flex items-center gap-1">
                Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        <div class="divide-y divide-slate-800">
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-800/50 transition-colors">
                <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 font-bold text-sm shrink-0">
                    {{ substr($order->customer_name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-200 text-sm font-medium truncate">{{ $order->customer_name }}</p>
                    <p class="text-slate-500 text-xs font-mono">{{ $order->order_number }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-amber-400 text-sm font-semibold tabular-nums">{{ $order->formattedTotal() }}</p>
                    <span class="text-[10px] px-2 py-0.5 rounded-full border {{ $order->statusBadgeClass() }}">{{ $order->statusLabel() }}</span>
                </div>
            </a>
            @empty
            <div class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada pesanan</div>
            @endforelse
        </div>
    </div>

    {{-- Order Status Chart (simple) --}}
    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6">
        <h3 class="font-semibold text-slate-100 mb-5">Status Pesanan</h3>
        @php
            $pendingCount = $orderStatusSummary->filter(fn($cnt, $k) => $k !== 'delivered' && $k !== 'selesai')->sum();
            $deliveredCount = $orderStatusSummary->get('delivered', 0) + $orderStatusSummary->get('selesai', 0);
            $statusDefs = [
                'pending'   => ['label' => 'Belum Selesai', 'count' => $pendingCount,   'color' => 'bg-amber-500'],
                'delivered' => ['label' => 'Selesai',       'count' => $deliveredCount, 'color' => 'bg-emerald-500'],
            ];
            $totalOrders = $pendingCount + $deliveredCount;
        @endphp
        <div class="space-y-4">
            @foreach($statusDefs as $key => $def)
            @php $count = $def['count']; $pct = $totalOrders > 0 ? round($count / $totalOrders * 100) : 0; @endphp
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm text-slate-400">{{ $def['label'] }}</span>
                    <span class="text-sm font-semibold text-slate-300 tabular-nums">{{ $count }} <span class="text-slate-600 font-normal">({{ $pct }}%)</span></span>
                </div>
                <div class="h-2.5 bg-slate-800 rounded-full overflow-hidden">
                    <div class="{{ $def['color'] }} h-full rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        @if($totalOrders == 0)
        <p class="text-center text-slate-500 text-sm py-8">Belum ada data pesanan</p>
        @endif
    </div>
</div>

{{-- Recent Contact Messages --}}
<div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h3 class="font-semibold text-slate-100">Pesan Kontak Terbaru</h3>
            @if($stats['unread_messages'] > 0)
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30">
                    {{ $stats['unread_messages'] }} Belum Dibaca
                </span>
            @endif
        </div>
        <a href="{{ route('admin.messages.index') }}" class="text-xs text-amber-400 hover:text-amber-300 flex items-center gap-1">
            Lihat Semua Pesan <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>
    <div class="divide-y divide-slate-800">
        @forelse($recentMessages as $msg)
        <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-800/50 transition-colors group">
            <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700/50 flex items-center justify-center text-slate-300 font-bold text-sm shrink-0">
                {{ strtoupper(substr($msg->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <p class="text-slate-200 text-sm font-medium truncate group-hover:text-amber-400 transition-colors">{{ $msg->name }}</p>
                    <span class="text-xs text-slate-500">• {{ $msg->email }}</span>
                </div>
                <p class="text-slate-400 text-xs truncate mt-0.5"><span class="font-medium text-slate-300">{{ $msg->subject }}</span>: {{ $msg->message }}</p>
            </div>
            <div class="text-right shrink-0 flex flex-col items-end gap-1">
                @if($msg->status === 'unread')
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        Baru
                    </span>
                @else
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 border border-slate-700/50">
                        Dibaca
                    </span>
                @endif
                <span class="text-[11px] text-slate-500">{{ $msg->created_at->diffForHumans() }}</span>
            </div>
        </a>
        @empty
        <div class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada pesan kontak yang masuk</div>
        @endforelse
    </div>
</div>

@endsection
