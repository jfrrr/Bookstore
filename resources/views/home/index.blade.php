@extends('layouts.app')
@section('title', 'BookStore')
@section('meta_description', 'BookStore — Toko buku online terpercaya. Temukan ribuan judul buku pilihan dengan pengiriman COD ke seluruh Indonesia.')

@section('content')

{{-- HERO SECTION --}}
<section class="relative mx-4 my-6 rounded-3xl overflow-hidden shadow-2xl" style="background: linear-gradient(135deg, #1C1917 0%, #292524 50%, #451A03 100%);">
    {{-- Ambient Glows --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-[#8d4b00]/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-[32rem] h-[32rem] rounded-full bg-[#ffc329]/10 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

        {{-- Left: Copy & CTA --}}
        <div class="lg:col-span-7 flex flex-col items-start">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 text-[#ffdf9f] text-xs font-semibold tracking-wider uppercase backdrop-blur-md">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ffc329] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ffdf9f]"></span>
                </span>
                Koleksi Terbaru 2026 Ready Stock
            </div>
            <h1 class="mt-6 font-['Playfair_Display'] font-bold text-4xl lg:text-6xl text-white leading-tight tracking-tight">
                Jelajahi Dunia Lewat <br>
                <span class="bg-gradient-to-r from-[#f9bd22] via-[#ffc329] to-[#ffb68e] bg-clip-text text-transparent">Lembaran Buku</span> Impian Anda
            </h1>
            <p class="mt-6 text-[#dbc2b0] text-lg max-w-xl leading-relaxed">
                Temukan ribuan karya literatur terbaik dari fiksi, pengembangan diri, pemrograman, hingga sejarah. Bayar di tempat (COD).
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ route('books.index') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-semibold bg-[#ffc329] text-[#261a00] hover:bg-[#ffdf9f] shadow-lg shadow-amber-900/20 transition-all duration-200 transform hover:-translate-y-0.5">
                    <span>Eksplor Katalog Buku</span>
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
                <a href="{{ route('about') }}"
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-sm text-white bg-white/10 hover:bg-white/20 backdrop-blur-md transition-colors">
                    Tentang BookStore
                </a>
            </div>

            {{-- Trust Metrics --}}
            <div class="mt-12 w-full grid grid-cols-3 gap-4 bg-white/5 rounded-2xl p-4 backdrop-blur-sm">
                @foreach([['verified', '100% Original', 'Langsung Penerbit'], ['payments', 'Layanan COD', 'Bayar di Tempat'], ['support_agent', '24/7 Ramah', 'Siap Melayani']] as [$icon, $title, $sub])
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#ffc329]/20 flex items-center justify-center text-[#ffdf9f]">
                        <span class="material-symbols-outlined text-xl">{{ $icon }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm leading-tight">{{ $title }}</p>
                        <p class="text-[#dbc2b0] text-xs">{{ $sub }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right: Spotlight Card --}}
        <div class="lg:col-span-5 flex justify-center">
            <div class="relative w-full max-w-sm bg-white/10 backdrop-blur-xl rounded-3xl p-6 shadow-2xl overflow-hidden">
                <div class="absolute -top-10 -right-10 w-36 h-36 bg-[#ffc329]/20 rounded-full blur-2xl"></div>
                <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#ffc329]/20 text-[#ffdf9f] uppercase tracking-wider">
                        <span class="material-symbols-outlined text-sm">local_fire_department</span>
                        Bestseller Bulan Ini
                    </span>
                </div>
                @php $hero = $spotlightBook ?? $newArrivals->first(); @endphp
                @if($hero)
                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden mb-4 bg-[#342f2b] flex items-center justify-center">
                    @if($hero->cover_image)
                        <img src="{{ Storage::url($hero->cover_image) }}" alt="{{ $hero->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center">
                            <span class="material-symbols-outlined text-6xl text-[#ffb77d] mb-3" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                            <span class="font-['Playfair_Display'] text-white font-bold text-lg leading-tight">{{ $hero->title }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <span class="inline-block bg-white/20 backdrop-blur text-white text-xs px-2 py-1 rounded-lg">{{ $hero->category->name }}</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-['Playfair_Display'] font-bold text-white text-lg leading-tight">{{ Str::limit($hero->title, 40) }}</h3>
                    <p class="text-[#dbc2b0] text-sm mt-1">{{ $hero->author }}</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-bold text-[#ffc329] text-xl tabular-nums whitespace-nowrap">{{ $hero->formattedPrice() }}</span>
                        <a href="{{ route('books.show', $hero) }}"
                           class="flex items-center gap-1 bg-[#ffc329] text-[#261a00] text-sm font-semibold px-4 py-2 rounded-xl hover:bg-[#ffdf9f] transition-colors">
                            Lihat Detail
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES SECTION --}}
<section class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Jelajahi Koleksi</span>
            <h2 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-1">Kategori Buku</h2>
        </div>
        <a href="{{ route('books.index') }}" class="flex items-center gap-1 text-sm text-[#8d4b00] font-semibold hover:underline">
            Lihat Semua <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($categories as $category)
        <a href="{{ route('books.index', ['category' => $category->slug]) }}"
           class="group flex flex-col items-center gap-2 p-4 rounded-2xl bg-white border border-[#e7e5e4] hover:border-[#fde68a] hover:shadow-md transition-all duration-200 text-center book-card-hover">
            @php
                $icons = ['Fiksi' => 'auto_stories', 'Teknologi' => 'computer', 'Bisnis' => 'trending_up', 'Pengembangan Diri' => 'psychology', 'Pendidikan' => 'school', 'Sejarah' => 'history_edu', 'Sains' => 'science', 'Romantis' => 'favorite'];
                $icon = $icons[$category->name] ?? 'menu_book';
            @endphp
            <div class="w-12 h-12 rounded-xl bg-[#ffdcc3] flex items-center justify-center text-[#8d4b00] group-hover:bg-[#8d4b00] group-hover:text-white transition-colors">
                <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
            </div>
            <span class="text-xs font-medium text-[#1f1b17] leading-tight">{{ $category->name }}</span>
            <span class="text-xs text-[#887364]">{{ $category->books_count }} buku</span>
        </a>
        @endforeach
    </div>
</section>

{{-- NEW ARRIVALS / KOLEKSI TERBARU --}}
@if($newArrivals->count() > 0)
<section class="max-w-7xl mx-auto px-4 lg:px-8 pb-14">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Baru Ditambahkan</span>
            <h2 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-1">Koleksi Terbaru</h2>
        </div>
        <a href="{{ route('books.index') }}" class="flex items-center gap-1 text-sm text-[#8d4b00] font-semibold hover:underline">
            Lihat Semua <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($newArrivals as $book)
            @include('components.book-card', ['book' => $book])
        @endforeach
    </div>
</section>
@endif

{{-- PROMOTIONAL BANNER --}}
<section class="mx-4 my-6 rounded-3xl bg-[#f6ece6] border border-[#dbc2b0] overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 py-16 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
            <span class="material-symbols-outlined text-5xl text-[#8d4b00] mb-4 block" style="font-variation-settings: 'FILL' 1;">format_quote</span>
            <blockquote class="font-['Playfair_Display'] font-bold text-2xl lg:text-3xl text-[#1f1b17] leading-tight italic">
                "Buku yang baik adalah perjalanan yang menunggu untuk dimulai."
            </blockquote>
            <p class="mt-4 text-[#554336] text-sm">— Setiap buku di BookStore dipilih dengan penuh cinta</p>
        </div>
        <div class="shrink-0 flex flex-col items-center gap-4">
            <div class="grid grid-cols-3 gap-3 text-center">
                @foreach([['5.000+', 'Judul Buku'], ['10.000+', 'Pelanggan'], ['100%', 'Original']] as [$num, $label])
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-[#e7e5e4]">
                    <div class="font-['Playfair_Display'] font-bold text-2xl text-[#8d4b00] tabular-nums">{{ $num }}</div>
                    <div class="text-xs text-[#554336] mt-1">{{ $label }}</div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('books.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#8d4b00] text-white font-semibold hover:bg-[#6e3900] transition-colors">
                Mulai Belanja
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

{{-- ABOUT PREVIEW --}}
<section class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
    <div class="rounded-3xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 bg-[#342f2b]">
        <div class="p-10 lg:p-14 flex flex-col justify-center">
            <span class="text-[#ffb77d] text-xs font-bold uppercase tracking-widest">Tentang Kami</span>
            <h2 class="font-['Playfair_Display'] font-bold text-3xl text-white mt-3 leading-tight">
                Lebih dari Sekadar Toko Buku
            </h2>
            <p class="mt-4 text-[#dbc2b0] leading-relaxed">
                BookStore adalah komunitas pecinta literatur yang percaya bahwa setiap buku membuka pintu ke dunia baru. Kami hadir untuk memudahkan akses Anda ke koleksi terbaik.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                @foreach(['Koleksi Terlengkap', 'COD Seluruh Indonesia', 'Buku 100% Original', 'Layanan 24/7'] as $feature)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#554336] text-[#ffb77d] text-xs font-medium">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    {{ $feature }}
                </span>
                @endforeach
            </div>
            <a href="{{ route('about') }}"
               class="mt-8 self-start inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#ffb77d] text-[#1f1b17] font-semibold hover:bg-[#ffdcc3] transition-colors">
                Pelajari Lebih Lanjut
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
        <div class="bg-[#1c1917] flex items-center justify-center p-10 min-h-48">
            <div class="grid grid-cols-2 gap-4 w-full max-w-xs">
                @foreach([['menu_book', 'Ribuan Judul', 'Dari berbagai genre'], ['local_shipping', 'COD Nationwide', 'Bayar di tempat'], ['workspace_premium', 'Buku Original', '100% asli'], ['support_agent', 'Customer Care', 'Siap melayani']] as [$icon, $title, $sub])
                <div class="bg-[#342f2b] rounded-2xl p-4 flex flex-col gap-2">
                    <span class="material-symbols-outlined text-[#ffb77d] text-2xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ $title }}</p>
                        <p class="text-[#887364] text-xs">{{ $sub }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
