{{-- Glassmorphic navigation bar for BookStore storefront --}}
<header class="fixed top-0 inset-x-0 z-50 bg-[rgba(255,248,245,0.9)] backdrop-blur-md border-b border-[rgba(231,229,228,0.8)] shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="h-16 max-w-7xl mx-auto px-4 lg:px-8 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <div class="flex items-center gap-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <span class="material-symbols-outlined text-[#8d4b00] text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                <span class="font-['Playfair_Display'] font-bold text-xl text-[#8d4b00] tracking-tight">BookStore</span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}"
                   class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-[#8d4b00] font-semibold' : 'text-[#554336] hover:text-[#8d4b00]' }}">
                    Beranda
                </a>
                <a href="{{ route('books.index') }}"
                   class="text-sm font-medium transition-colors {{ request()->routeIs('books.*') ? 'text-[#8d4b00] font-semibold' : 'text-[#554336] hover:text-[#8d4b00]' }}">
                    Buku
                </a>
                @auth
                    <a href="{{ route('orders.index') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('orders.*') ? 'text-[#8d4b00] font-semibold' : 'text-[#554336] hover:text-[#8d4b00]' }}">
                        Pesanan Saya
                    </a>
                @endauth
                <a href="{{ route('about') }}"
                   class="text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-[#8d4b00] font-semibold' : 'text-[#554336] hover:text-[#8d4b00]' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('contact') }}"
                   class="text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-[#8d4b00] font-semibold' : 'text-[#554336] hover:text-[#8d4b00]' }}">
                    Kontak
                </a>
            </nav>
        </div>


        {{-- Right Actions --}}
        <div class="flex items-center gap-3">
            {{-- Cart Icon --}}
            @auth
                <a href="{{ route('cart.index') }}" class="relative p-2 text-[#554336] hover:text-[#8d4b00] transition-colors">
                    <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                    @php
                        $userCart = auth()->user()->cart;
                        $cartCount = $userCart ? $userCart->items()->count() : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-[#8d4b00] text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>
            @endauth

            {{-- Auth Actions --}}
            @auth
                <div class="flex items-center gap-2 pl-1">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-500/10 text-[#8d4b00] border border-amber-500/30 text-xs font-semibold hover:bg-amber-500/20 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                            <span>Admin Panel</span>
                        </a>
                    @endif
                    <div class="w-8 h-8 rounded-full bg-[#ffdcc3] flex items-center justify-center text-[#8d4b00] font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="hidden md:block text-sm font-medium text-[#1f1b17]">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-[#554336] hover:text-[#8d4b00] transition-colors px-2 py-1">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-[#554336] hover:text-[#8d4b00] transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="text-sm font-semibold bg-[#8d4b00] text-white px-4 py-2 rounded-lg hover:bg-[#6e3900] transition-colors">
                    Daftar
                </a>
            @endauth

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 text-[#554336] hover:text-[#8d4b00]">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-[#e7e5e4] px-4 py-4 space-y-3">
        <a href="{{ route('home') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Beranda</a>
        <a href="{{ route('books.index') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Buku</a>
        <a href="{{ route('about') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Tentang Kami</a>
        <a href="{{ route('contact') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Kontak</a>
        @auth
            <a href="{{ route('orders.index') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Pesanan Saya</a>
            <a href="{{ route('cart.index') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Keranjang</a>
        @else
            <a href="{{ route('login') }}" class="block py-2 text-sm font-medium text-[#1f1b17] hover:text-[#8d4b00]">Masuk</a>
            <a href="{{ route('register') }}" class="block py-2 text-sm font-semibold text-[#8d4b00]">Daftar</a>
        @endauth
    </div>
</header>

<script>
    document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
        document.getElementById('mobile-menu')?.classList.toggle('hidden');
    });
</script>
