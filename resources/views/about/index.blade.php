@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')
{{-- Hero --}}
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #342f2b 0%, #1c1917 100%);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-[#ffc329] blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-20 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#ffb77d]/20 text-[#ffdf9f] text-xs font-bold uppercase tracking-widest mb-6">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">favorite</span>
            Tentang BookStore
        </span>
        <h1 class="font-['Playfair_Display'] font-bold text-4xl lg:text-5xl text-white leading-tight">
            Lebih dari Sekadar <span class="text-[#ffdf9f]">Toko Buku</span>
        </h1>
        <p class="mt-6 text-[#dbc2b0] text-lg max-w-2xl mx-auto leading-relaxed">
            Kami adalah komunitas pecinta literatur yang percaya bahwa setiap buku membuka pintu menuju dunia yang lebih luas, lebih kaya, dan lebih bermakna.
        </p>
    </div>
</section>

{{-- Mission & Vision --}}
<section class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-[#f6ece6] rounded-2xl p-8 border border-[#dbc2b0]">
            <div class="w-12 h-12 rounded-xl bg-[#8d4b00] flex items-center justify-center mb-5">
                <span class="material-symbols-outlined text-white text-2xl" style="font-variation-settings: 'FILL' 1;">track_changes</span>
            </div>
            <h2 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17] mb-4">Misi Kami</h2>
            <p class="text-[#554336] leading-relaxed">
                Menyediakan akses mudah dan terjangkau ke koleksi buku berkualitas bagi seluruh masyarakat Indonesia. Kami berkomitmen untuk menjadi mitra terpercaya dalam perjalanan literasi Anda.
            </p>
        </div>
        <div class="bg-[#342f2b] rounded-2xl p-8">
            <div class="w-12 h-12 rounded-xl bg-[#ffb77d] flex items-center justify-center mb-5">
                <span class="material-symbols-outlined text-[#342f2b] text-2xl" style="font-variation-settings: 'FILL' 1;">visibility</span>
            </div>
            <h2 class="font-['Playfair_Display'] font-bold text-2xl text-white mb-4">Visi Kami</h2>
            <p class="text-[#dbc2b0] leading-relaxed">
                Menjadi toko buku online terkemuka di Indonesia yang menginspirasi jutaan pembaca untuk terus belajar, berkembang, dan berbagi pengetahuan melalui kekuatan literasi.
            </p>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Yang Membuat Kami Berbeda</span>
            <h2 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-2">Nilai-Nilai BookStore</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['verified', 'Keaslian', 'Semua buku 100% original langsung dari penerbit resmi'],
                ['local_shipping', 'Kemudahan', 'COD (bayar di tempat) ke seluruh Indonesia tanpa ribet'],
                ['psychology', 'Kurasi', 'Tim kami memilih buku-buku terbaik di setiap kategori'],
                ['support_agent', 'Layanan', 'Customer care 24/7 siap membantu kebutuhan Anda'],
            ] as [$icon, $title, $desc])
            <div class="flex flex-col items-center text-center p-6 rounded-2xl bg-[#fcf2eb] border border-[#f0e6e0]">
                <div class="w-14 h-14 rounded-2xl bg-[#8d4b00] flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-white text-2xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                </div>
                <h3 class="font-['Playfair_Display'] font-bold text-lg text-[#1f1b17] mb-2">{{ $title }}</h3>
                <p class="text-[#887364] text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="max-w-7xl mx-auto px-4 lg:px-8 py-16 text-center">
    <h2 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mb-4">Siap Mulai Petualangan Membaca?</h2>
    <p class="text-[#554336] max-w-md mx-auto mb-8">Jelajahi ribuan judul buku pilihan dan temukan yang sempurna untuk Anda.</p>
    <a href="{{ route('books.index') }}"
       class="inline-flex items-center gap-2 bg-[#8d4b00] text-white font-semibold px-8 py-4 rounded-xl hover:bg-[#6e3900] transition-colors text-lg">
        <span class="material-symbols-outlined">explore</span>
        Jelajahi Katalog Buku
    </a>
</section>
@endsection
