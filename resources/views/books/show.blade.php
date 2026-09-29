@extends('layouts.app')
@section('title', $book->title)
@section('meta_description', Str::limit($book->description, 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-[#887364] mb-8">
        <a href="{{ route('home') }}" class="hover:text-[#8d4b00] transition-colors">Beranda</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a href="{{ route('books.index') }}" class="hover:text-[#8d4b00] transition-colors">Buku</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a href="{{ route('books.index', ['category' => $book->category->slug]) }}" class="hover:text-[#8d4b00] transition-colors">{{ $book->category->name }}</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-[#1f1b17] font-medium">{{ Str::limit($book->title, 30) }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- Left: Cover --}}
        <div class="lg:col-span-4">
            <div class="sticky top-24">
                <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-[#f6ece6] shadow-xl">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                             class="w-full h-full object-cover book-spine">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-8 text-center bg-gradient-to-b from-[#f6ece6] to-[#eae1da] book-spine">
                            <span class="material-symbols-outlined text-8xl text-[#8d4b00]/30 mb-4" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                            <span class="font-['Playfair_Display'] text-xl font-bold text-[#1f1b17] leading-tight">{{ $book->title }}</span>
                            <span class="text-[#887364] text-sm mt-2">{{ $book->author }}</span>
                        </div>
                    @endif
                </div>

                {{-- Stock indicator --}}
                <div class="mt-4 flex items-center gap-2 px-4 py-3 rounded-xl {{ $book->stock > 0 ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200' }}">
                    <span class="material-symbols-outlined text-lg {{ $book->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}" style="font-variation-settings: 'FILL' 1;">
                        {{ $book->stock > 0 ? 'inventory_2' : 'remove_shopping_cart' }}
                    </span>
                    <span class="text-sm font-medium {{ $book->stock > 0 ? 'text-emerald-700' : 'text-red-600' }}">
                        {{ $book->stock > 0 ? "Tersedia ({$book->stock} stok)" : 'Stok Habis' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="lg:col-span-8">
            {{-- Category badge --}}
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#fffbeb] text-[#b45309] border border-[#fef3c7] text-xs font-semibold">
                {{ $book->category->name }}
            </span>

            {{-- Title --}}
            <h1 class="font-['Playfair_Display'] font-bold text-3xl lg:text-4xl text-[#1f1b17] mt-4 leading-tight">
                {{ $book->title }}
            </h1>
            <p class="text-[#554336] text-lg mt-2">oleh <strong>{{ $book->author }}</strong></p>

            {{-- Price --}}
            <div class="my-6 flex items-center gap-4">
                <span class="font-bold text-4xl text-[#8d4b00] tabular-nums whitespace-nowrap">{{ $book->formattedPrice() }}</span>
                <span class="text-sm text-[#887364] bg-[#f6ece6] px-3 py-1 rounded-full">Bayar di Tempat (COD)</span>
            </div>

            {{-- Add to Cart Form --}}
            @if($book->stock > 0)
                @auth
                    <form action="{{ route('cart.store') }}" method="POST" class="flex items-center gap-3 mb-8">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="flex items-center border border-[#dbc2b0] rounded-xl overflow-hidden">
                            <button type="button" id="qty-minus"
                                    class="w-10 h-11 flex items-center justify-center text-[#554336] hover:bg-[#f6ece6] transition-colors">
                                <span class="material-symbols-outlined text-lg">remove</span>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $book->stock }}"
                                   class="w-14 text-center h-11 text-[#1f1b17] font-semibold text-base border-x border-[#dbc2b0] focus:outline-none bg-white">
                            <button type="button" id="qty-plus"
                                    class="w-10 h-11 flex items-center justify-center text-[#554336] hover:bg-[#f6ece6] transition-colors">
                                <span class="material-symbols-outlined text-lg">add</span>
                            </button>
                        </div>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 bg-[#8d4b00] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#6e3900] transition-colors">
                            <span class="material-symbols-outlined">add_shopping_cart</span>
                            Tambah ke Keranjang
                        </button>
                        <a href="{{ route('cart.index') }}"
                           class="flex items-center gap-2 border border-[#8d4b00] text-[#8d4b00] font-semibold px-5 py-3 rounded-xl hover:bg-[#8d4b00] hover:text-white transition-colors">
                            <span class="material-symbols-outlined">shopping_bag</span>
                        </a>
                    </form>
                @else
                    <div class="mb-8">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 bg-[#8d4b00] text-white font-semibold px-8 py-3 rounded-xl hover:bg-[#6e3900] transition-colors">
                            <span class="material-symbols-outlined">login</span>
                            Login untuk Membeli
                        </a>
                    </div>
                @endauth
            @else
                <div class="mb-8">
                    <button disabled class="flex items-center gap-2 bg-[#e7e5e4] text-[#887364] font-semibold px-8 py-3 rounded-xl cursor-not-allowed">
                        <span class="material-symbols-outlined">remove_shopping_cart</span>
                        Stok Habis
                    </button>
                </div>
            @endif

            {{-- Payment info --}}
            <div class="flex flex-wrap gap-3 mb-8">
                @foreach([['local_shipping', 'COD - Bayar di Tempat'], ['verified', 'Buku 100% Original'], ['assignment_return', 'Garansi Keamanan']] as [$icon, $text])
                <div class="flex items-center gap-2 text-sm text-[#554336] bg-[#f6ece6] px-3 py-2 rounded-xl">
                    <span class="material-symbols-outlined text-base text-[#8d4b00]">{{ $icon }}</span>
                    {{ $text }}
                </div>
                @endforeach
            </div>

            {{-- Description --}}
            <div class="border-t border-[#e7e5e4] pt-6">
                <h2 class="font-['Playfair_Display'] font-semibold text-xl text-[#1f1b17] mb-4">Deskripsi Buku</h2>
                <div class="prose prose-stone max-w-none text-[#554336] leading-relaxed">
                    {!! nl2br(e($book->description)) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Related Books --}}
    @if($relatedBooks->count() > 0)
    <div class="mt-16 border-t border-[#e7e5e4] pt-12">
        <h2 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17] mb-6">Buku Serupa</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
            @foreach($relatedBooks as $relatedBook)
                @include('components.book-card', ['book' => $relatedBook])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    const qtyInput = document.getElementById('quantity');
    const maxStock = {{ $book->stock }};
    document.getElementById('qty-minus')?.addEventListener('click', () => {
        if (parseInt(qtyInput.value) > 1) qtyInput.value = parseInt(qtyInput.value) - 1;
    });
    document.getElementById('qty-plus')?.addEventListener('click', () => {
        if (parseInt(qtyInput.value) < maxStock) qtyInput.value = parseInt(qtyInput.value) + 1;
    });
</script>
@endpush
@endsection
