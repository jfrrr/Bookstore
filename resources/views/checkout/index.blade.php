@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-6xl mx-auto px-4 lg:px-8 py-10">
    <div class="mb-8">
        <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Langkah Terakhir</span>
        <h1 class="font-['Playfair_Display'] font-bold text-3xl text-[#1f1b17] mt-1">Checkout</h1>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Delivery Form --}}
            <div class="lg:col-span-7 space-y-5">
                <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6">
                    <h2 class="font-['Playfair_Display'] font-semibold text-xl text-[#1f1b17] mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#8d4b00]">local_shipping</span>
                        Detail Pengiriman
                    </h2>
                    <div class="space-y-4">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-[#554336] mb-1.5">Nama Penerima <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('name') ? 'border-red-400 ring-2 ring-red-200' : 'border-[#dbc2b0]' }} text-[#1f1b17] focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00] text-sm"
                                   placeholder="Nama lengkap penerima paket">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-[#554336] mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('phone') ? 'border-red-400 ring-2 ring-red-200' : 'border-[#dbc2b0]' }} text-[#1f1b17] focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00] text-sm"
                                   placeholder="Contoh: 08123456789">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Address --}}
                        <div>
                            <label class="block text-sm font-medium text-[#554336] mb-1.5">Alamat Pengiriman Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="delivery_address" rows="3"
                                      class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('delivery_address') ? 'border-red-400 ring-2 ring-red-200' : 'border-[#dbc2b0]' }} text-[#1f1b17] focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00] text-sm resize-none"
                                      placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, kode pos">{{ old('delivery_address') }}</textarea>
                            @error('delivery_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6">
                    <h2 class="font-['Playfair_Display'] font-semibold text-xl text-[#1f1b17] mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#8d4b00]">payments</span>
                        Metode Pembayaran
                    </h2>
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-[#fffbeb] border-2 border-[#fbbf24]">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-[#8d4b00]">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
                        </div>
                        <div>
                            <p class="font-semibold text-[#1f1b17]">Bayar di Tempat (COD)</p>
                            <p class="text-xs text-[#887364]">Bayar tunai saat paket tiba di tangan Anda</p>
                        </div>
                        <span class="ml-auto bg-[#fbbf24] text-[#451A03] text-xs font-bold px-2.5 py-1 rounded-full">Dipilih</span>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl border border-[#e7e5e4] p-6 sticky top-24">
                    <h2 class="font-['Playfair_Display'] font-bold text-xl text-[#1f1b17] mb-5">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-5 max-h-60 overflow-y-auto">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-14 rounded-lg overflow-hidden bg-[#f6ece6] shrink-0">
                                @if($item->book->cover_image)
                                    <img src="{{ Storage::url($item->book->cover_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xl text-[#8d4b00]/30">menu_book</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-[#1f1b17] line-clamp-1">{{ $item->book->title }}</p>
                                <p class="text-xs text-[#887364]">×{{ $item->quantity }}</p>
                            </div>
                            <span class="font-semibold text-sm text-[#8d4b00] tabular-nums shrink-0">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-[#e7e5e4] pt-4 mb-6 space-y-2">
                        <div class="flex justify-between text-sm text-[#554336]">
                            <span>Subtotal</span>
                            <span class="tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-[#554336]">
                            <span>Ongkos Kirim</span>
                            <span class="text-emerald-600 font-medium">Gratis</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t border-[#e7e5e4] pt-3 mt-3">
                            <span class="text-[#1f1b17]">Total</span>
                            <span class="text-[#8d4b00] tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-[#8d4b00] text-white font-semibold py-4 rounded-xl hover:bg-[#6e3900] transition-colors">
                        <span class="material-symbols-outlined">check_circle</span>
                        Buat Pesanan Sekarang
                    </button>

                    <p class="text-center text-xs text-[#887364] mt-3">
                        Dengan memesan, Anda setuju dengan syarat & ketentuan BookStore
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
