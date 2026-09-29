{{-- Reusable book card component with warm literary aesthetic --}}
@php
    $isInStock = $book->stock > 0;
@endphp
<div class="group flex flex-col bg-white border border-[#e7e5e4] rounded-2xl overflow-hidden book-card-hover">
    {{-- Book Cover --}}
    <a href="{{ route('books.show', $book) }}" class="block relative aspect-[3/4] bg-[#f6ece6] overflow-hidden">
        @if($book->cover_image)
            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 book-spine">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-gradient-to-b from-[#f6ece6] to-[#eae1da] book-spine">
                <span class="material-symbols-outlined text-5xl text-[#8d4b00]/40 mb-2" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                <span class="font-['Playfair_Display'] text-sm font-semibold text-[#1f1b17] leading-tight text-center px-2">{{ Str::limit($book->title, 35) }}</span>
            </div>
        @endif

        {{-- Category Badge --}}
        <div class="absolute top-3 left-3">
            <span class="inline-block bg-[#fffbeb] text-[#b45309] border border-[#fef3c7] text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                {{ $book->category->name }}
            </span>
        </div>

        {{-- Out of Stock Overlay --}}
        @if(!$isInStock)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Stok Habis</span>
            </div>
        @endif
    </a>

    {{-- Book Info --}}
    <div class="flex flex-col flex-1 p-4 gap-3">
        <div class="flex-1">
            <a href="{{ route('books.show', $book) }}">
                <h3 class="font-['Playfair_Display'] font-semibold text-base text-[#1f1b17] leading-snug hover:text-[#8d4b00] transition-colors line-clamp-2">
                    {{ $book->title }}
                </h3>
            </a>
            <p class="text-[#887364] text-xs mt-1">{{ $book->author }}</p>
        </div>

        <div class="flex items-center justify-between gap-1.5 sm:gap-2 mt-auto">
            <span class="font-bold text-[#8d4b00] text-sm sm:text-base tabular-nums whitespace-nowrap shrink-0">{{ $book->formattedPrice() }}</span>
            @if($isInStock)
                @auth
                    <form action="{{ route('cart.store') }}" method="POST" class="inline shrink-0">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                class="flex items-center gap-1 bg-[#8d4b00] text-white text-xs font-semibold px-2.5 sm:px-3 py-1.5 sm:py-2 rounded-xl hover:bg-[#6e3900] transition-colors whitespace-nowrap">
                            <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                            <span class="hidden sm:inline">Keranjang</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-1 border border-[#8d4b00] text-[#8d4b00] text-xs font-semibold px-2.5 sm:px-3 py-1.5 sm:py-2 rounded-xl hover:bg-[#8d4b00] hover:text-white transition-colors whitespace-nowrap shrink-0">
                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                        <span class="hidden sm:inline">Beli</span>
                    </a>
                @endauth
            @else
                <span class="text-xs text-red-500 font-medium whitespace-nowrap">Stok Habis</span>
            @endif
        </div>
    </div>
</div>
