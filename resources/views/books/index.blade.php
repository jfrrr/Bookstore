@extends('layouts.app')
@section('title', 'Katalog Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Koleksi Lengkap</span>
        <h1 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-1">Katalog Buku</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar Filter --}}
        <aside class="lg:w-64 shrink-0">
            <form action="{{ route('books.index') }}" method="GET" id="filter-form">
                <div class="bg-white rounded-2xl border border-[#e7e5e4] p-5 space-y-6 sticky top-24">

                    {{-- Search --}}
                    <div>
                        <label class="text-xs font-bold text-[#554336] uppercase tracking-wider block mb-2">Cari Buku</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[#887364] text-lg">search</span>
                            <input type="search" name="search" value="{{ request('search') }}"
                                   placeholder="Judul atau penulis..."
                                   class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-[#f6ece6] text-sm text-[#1f1b17] placeholder:text-[#887364] focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:bg-white transition-all">
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div>
                        <label class="text-xs font-bold text-[#554336] uppercase tracking-wider block mb-2">Kategori</label>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} class="accent-[#8d4b00]" onchange="this.form.submit()">
                                <span class="text-sm text-[#1f1b17]">Semua Kategori</span>
                            </label>
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} class="accent-[#8d4b00]" onchange="this.form.submit()">
                                <span class="text-sm text-[#1f1b17]">{{ $cat->name }}</span>
                                <span class="ml-auto text-xs text-[#887364]">{{ $cat->books_count }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sort --}}
                    <div>
                        <label class="text-xs font-bold text-[#554336] uppercase tracking-wider block mb-2">Urutan</label>
                        <select name="sort" onchange="this.form.submit()"
                                class="w-full py-2.5 px-3 rounded-xl bg-[#f6ece6] text-sm text-[#1f1b17] border border-[#dbc2b0] focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul A-Z</option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul Z-A</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    @if(request()->anyFilled(['search', 'category', 'sort']))
                    <a href="{{ route('books.index') }}" class="flex items-center gap-1.5 text-sm text-[#8d4b00] font-medium hover:underline">
                        <span class="material-symbols-outlined text-base">refresh</span>
                        Reset Filter
                    </a>
                    @endif
                </div>
            </form>
        </aside>

        {{-- Book Grid --}}
        <div class="flex-1">

            {{-- Results Info --}}
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm text-[#554336]">
                    Menampilkan <strong>{{ $books->firstItem() }}-{{ $books->lastItem() }}</strong> dari <strong>{{ $books->total() }}</strong> buku
                    @if(request('search'))
                        untuk "<em class="text-[#8d4b00]">{{ request('search') }}</em>"
                    @endif
                </p>
            </div>

            @if($books->isEmpty())
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <span class="material-symbols-outlined text-6xl text-[#dbc2b0] mb-4">search_off</span>
                    <h3 class="font-['Playfair_Display'] font-semibold text-xl text-[#1f1b17] mb-2">Buku Tidak Ditemukan</h3>
                    <p class="text-[#887364] text-sm max-w-sm">Coba ubah kata kunci pencarian atau pilih kategori yang berbeda.</p>
                    <a href="{{ route('books.index') }}" class="mt-6 px-5 py-2.5 rounded-xl bg-[#8d4b00] text-white text-sm font-semibold hover:bg-[#6e3900] transition-colors">
                        Lihat Semua Buku
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($books as $book)
                        @include('components.book-card', ['book' => $book])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
