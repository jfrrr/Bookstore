@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-10">
    <div class="mb-8">
        <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Tinjauan Pesanan</span>
        <h1 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-1">Keranjang Belanja</h1>
    </div>

    @if(!$cart || $cart->items->isEmpty())
        {{-- Empty Cart State --}}
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-20 h-20 rounded-full bg-[#f6ece6] flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-4xl text-[#8d4b00]/40">shopping_bag</span>
            </div>
            <h2 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17] mb-2">Keranjang Anda Kosong</h2>
            <p class="text-[#887364] text-sm mb-8">Temukan buku menarik dan tambahkan ke keranjang Anda.</p>
            <a href="{{ route('books.index') }}"
               class="inline-flex items-center gap-2 bg-[#8d4b00] text-white font-semibold px-7 py-3 rounded-xl hover:bg-[#6e3900] transition-colors">
                <span class="material-symbols-outlined">explore</span>
                Jelajahi Buku
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- Cart Items --}}
            <div class="lg:col-span-8 space-y-4">
                @foreach($cart->items as $item)
                <div class="bg-white rounded-2xl border border-[#e7e5e4] p-5 flex gap-5 items-start">
                    {{-- Book Cover --}}
                    <div class="w-20 h-28 rounded-xl overflow-hidden bg-[#f6ece6] shrink-0">
                        @if($item->book->cover_image)
                            <img src="{{ Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl text-[#8d4b00]/30" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                            </div>
                        @endif
                    </div>

                    {{-- Item Info --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('books.show', $item->book) }}" class="font-['Playfair_Display'] font-semibold text-base text-[#1f1b17] hover:text-[#8d4b00] transition-colors line-clamp-2">
                            {{ $item->book->title }}
                        </a>
                        <p class="text-[#887364] text-sm mt-1">{{ $item->book->author }}</p>
                        <p class="text-[#887364] text-xs mt-1">{{ $item->book->category->name }}</p>

                        <div class="flex items-center justify-between mt-4 flex-wrap gap-3">
                            {{-- Quantity Control --}}
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center border border-[#dbc2b0] rounded-xl overflow-hidden">
                                    <button type="button" onclick="updateQty(this, -1, {{ $item->book->stock }})"
                                            class="w-8 h-9 flex items-center justify-center text-[#554336] hover:bg-[#f6ece6]">
                                        <span class="material-symbols-outlined text-base">remove</span>
                                    </button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->book->stock }}"
                                           class="w-12 text-center h-9 text-sm font-semibold border-x border-[#dbc2b0] focus:outline-none"
                                           onchange="this.form.submit()">
                                    <button type="button" onclick="updateQty(this, 1, {{ $item->book->stock }})"
                                            class="w-8 h-9 flex items-center justify-center text-[#554336] hover:bg-[#f6ece6]">
                                        <span class="material-symbols-outlined text-base">add</span>
                                    </button>
                                </div>
                            </form>

                            <div class="flex items-center gap-3">
                                <span class="font-bold text-[#8d4b00] text-lg tabular-nums">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </span>
                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors"
                                            onclick="return confirm('Hapus buku ini dari keranjang?')">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6 sticky top-24">
                    <h2 class="font-['Playfair_Display'] font-bold text-xl text-[#1f1b17] mb-5">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-sm text-[#554336]">
                            <span>Subtotal ({{ $cart->items->sum('quantity') }} buku)</span>
                            <span class="font-semibold tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-[#554336]">
                            <span>Metode Pembayaran</span>
                            <span class="font-medium text-[#8d4b00]">Bayar di Tempat</span>
                        </div>
                    </div>

                    <div class="border-t border-[#e7e5e4] pt-4 mb-6">
                        <div class="flex justify-between">
                            <span class="font-bold text-[#1f1b17]">Total</span>
                            <span class="font-bold text-2xl text-[#8d4b00] tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="w-full flex items-center justify-center gap-2 bg-[#8d4b00] text-white font-semibold py-3.5 rounded-xl hover:bg-[#6e3900] transition-colors text-sm">
                        <span class="material-symbols-outlined">shopping_cart_checkout</span>
                        Lanjut ke Checkout
                    </a>

                    <a href="{{ route('books.index') }}"
                       class="w-full flex items-center justify-center gap-2 mt-3 border border-[#dbc2b0] text-[#554336] py-3 rounded-xl hover:bg-[#f6ece6] transition-colors text-sm">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateQty(btn, delta, maxStock) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const newVal = parseInt(input.value) + delta;
    if (newVal >= 1 && newVal <= maxStock) {
        input.value = newVal;
        form.submit();
    }
}
</script>
@endpush
@endsection
