{{-- Admin Sidebar Navigation (dark slate) --}}
<aside class="fixed left-0 top-0 h-full w-64 bg-[#020617] border-r border-slate-800 z-50 flex flex-col justify-between select-none">
    <div class="flex flex-col flex-1 overflow-y-auto">

        {{-- Brand Header --}}
        <div class="h-16 px-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-amber-400 text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                <span class="font-semibold text-slate-100 text-base tracking-tight">BookStore</span>
            </div>
            <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] px-2 py-0.5 rounded font-bold tracking-wider uppercase">Admin</span>
        </div>

        {{-- Navigation Items --}}
        <nav class="px-3 py-5 space-y-1">

            {{-- Dashboard --}}
            <p class="px-3 pb-2 text-[10px] uppercase tracking-widest text-slate-600 font-bold">Utama</p>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/10 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                <span>Dashboard</span>
            </a>

            {{-- Manajemen Toko --}}
            <p class="px-3 pb-2 pt-4 text-[10px] uppercase tracking-widest text-slate-600 font-bold">Manajemen Toko</p>
            <a href="{{ route('admin.books.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ request()->routeIs('admin.books.*') ? 'bg-amber-500/10 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <span class="material-symbols-outlined text-[20px]">book</span>
                <span>Katalog Buku</span>
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500/10 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <span class="material-symbols-outlined text-[20px]">folder</span>
                <span>Kategori</span>
            </a>

            {{-- Orders --}}
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500/10 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                    <span>Kelola Pesanan</span>
                </div>
                @php
                    $pendingCount = \App\Models\Order::where('status', '!=', 'delivered')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="bg-amber-500/20 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-500/30">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            {{-- Users --}}
            <p class="px-3 pb-2 pt-4 text-[10px] uppercase tracking-widest text-slate-600 font-bold">Pelanggan & Pesan</p>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ request()->routeIs('admin.users.*') ? 'bg-amber-500/10 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <span class="material-symbols-outlined text-[20px]">group</span>
                <span>Daftar Pelanggan</span>
            </a>
            <a href="{{ route('admin.messages.index') }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm transition-colors
                      {{ request()->routeIs('admin.messages.*') ? 'bg-amber-500/10 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                    <span>Pesan Kontak</span>
                </div>
                @php
                    $unreadMessagesCount = \App\Models\ContactMessage::where('status', 'unread')->count();
                @endphp
                @if($unreadMessagesCount > 0)
                    <span class="bg-amber-500/20 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-500/30">
                        {{ $unreadMessagesCount }}
                    </span>
                @endif
            </a>
        </nav>
    </div>

    {{-- Bottom --}}
    <div class="p-3 border-t border-slate-800">
        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:text-amber-400 hover:bg-slate-900 text-sm transition-colors">
            <span class="material-symbols-outlined text-[20px]">open_in_new</span>
            <span>Lihat Toko Publik</span>
        </a>
    </div>
</aside>
