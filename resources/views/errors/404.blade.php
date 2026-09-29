@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan (404)')
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan atau telah berpindah rak di BookStore.')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-16">
    <div class="max-w-2xl w-full text-center relative">

        {{-- Background Decorative Ambient Glow --}}
        <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-80 h-80 bg-[#ffdcc3]/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>

        {{-- Book & 404 Illustration Graphic --}}
        <div class="relative inline-flex items-center justify-center mb-8">
            {{-- Big 404 Watermark --}}
            <span class="text-8xl sm:text-9xl font-['Playfair_Display'] font-extrabold text-[#f0e6e0] select-none tracking-tight">
                404
            </span>

            {{-- Floating Book Graphic overlay --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="relative group">
                    {{-- Open Book Card Visual --}}
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-gradient-to-tr from-[#8d4b00] to-[#b15f00] text-white flex flex-col items-center justify-center shadow-2xl shadow-[#8d4b00]/25 transform group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-300 border-2 border-white/20">
                        <span class="material-symbols-outlined text-5xl sm:text-6xl text-[#ffdf9f]" style="font-variation-settings: 'FILL' 1;">
                            auto_stories
                        </span>
                        <span class="text-[10px] tracking-widest font-semibold uppercase text-white/80 mt-1">Halaman Hilang</span>
                    </div>

                    {{-- Small decorative floating bookmark badge --}}
                    <div class="absolute -bottom-2 -right-2 bg-white text-[#8d4b00] p-2 rounded-2xl shadow-md border border-[#f0e6e0] flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">search_off</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tagline & Headings --}}
        <div class="space-y-3 mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#f6ece6] text-[#8d4b00] text-xs font-bold uppercase tracking-wider border border-[#dbc2b0]/50">
                <span class="material-symbols-outlined text-sm">menu_book</span>
                Bab Yang Terlewat
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold font-['Playfair_Display'] text-[#1f1b17] tracking-tight">
                Halaman Ini Belum Ditulis
            </h1>
            <p class="text-sm sm:text-base text-[#887364] max-w-lg mx-auto leading-relaxed">
                Sepertinya lembaran buku yang Anda cari telah terlepas, berpindah rak perpustakaan, atau tautan yang Anda tuju sudah tidak tersedia.
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 mb-10">
            <a href="{{ route('home') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#8d4b00] hover:bg-[#6e3900] text-white px-7 py-3.5 rounded-2xl font-semibold text-sm shadow-lg shadow-[#8d4b00]/20 hover:shadow-xl transition-all">
                <span class="material-symbols-outlined text-[18px]">home</span>
                Kembali ke Beranda
            </a>
            <a href="{{ route('books.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#fcf2eb] hover:bg-[#f0e6e0] text-[#1f1b17] border border-[#dbc2b0] px-7 py-3.5 rounded-2xl font-semibold text-sm transition-all">
                <span class="material-symbols-outlined text-[18px] text-[#8d4b00]">explore</span>
                Jelajahi Katalog Buku
            </a>
        </div>

        {{-- Helpful Quick Links Section --}}
        <div class="pt-8 border-t border-[#f0e6e0] flex flex-wrap items-center justify-center gap-6 text-xs text-[#887364]">
            <span class="font-medium text-[#554336]">Mungkin Anda mencari:</span>
            <a href="{{ route('books.index') }}" class="hover:text-[#8d4b00] flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-sm">collections_bookmark</span>
                Semua Koleksi
            </a>
            <a href="{{ route('about') }}" class="hover:text-[#8d4b00] flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-sm">info</span>
                Tentang Kami
            </a>
            <a href="{{ route('contact') }}" class="hover:text-[#8d4b00] flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-sm">support_agent</span>
                Pusat Bantuan
            </a>
        </div>

    </div>
</div>
@endsection
