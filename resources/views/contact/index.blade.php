@extends('layouts.app')
@section('title', 'Kontak Kami')

@section('content')
<div class="max-w-6xl mx-auto px-4 lg:px-8 py-14">
    <div class="text-center mb-12">
        <span class="text-[#795900] text-xs font-bold uppercase tracking-widest">Hubungi Kami</span>
        <h1 class="font-['Playfair_Display'] font-bold text-4xl text-[#1f1b17] mt-2">Ada Pertanyaan?</h1>
        <p class="text-[#887364] mt-3 max-w-md mx-auto">Kami siap membantu. Kirim pesan dan tim kami akan merespons dalam waktu singkat.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- Contact Info --}}
        <div class="lg:col-span-4 space-y-5">
            @foreach([
                ['location_on', 'Lokasi', 'Jakarta, Indonesia', null],
                ['mail', 'Email', 'hello@bookstore.id', null],
                ['schedule', 'Jam Operasional', 'Senin–Sabtu: 08.00–20.00 WIB', null],
                ['payments', 'Pembayaran', 'Bayar di Tempat (COD) ke seluruh Indonesia', null],
            ] as [$icon, $label, $value, $_])
            <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#fcf2eb] border border-[#f0e6e0]">
                <div class="w-11 h-11 rounded-xl bg-[#8d4b00] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings: 'FILL' 1;">{{ $icon }}</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-[#887364] uppercase tracking-wider mb-0.5">{{ $label }}</p>
                    <p class="text-sm text-[#1f1b17] font-medium">{{ $value }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Contact Form --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-[#e7e5e4] p-8">
                <h2 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17] mb-6">Kirim Pesan</h2>

                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-[#554336] mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('name') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                                   placeholder="Nama Anda">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#554336] mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('email') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                                   placeholder="email@contoh.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#554336] mb-1.5">Subjek <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('subject') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                               placeholder="Topik pertanyaan Anda">
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#554336] mb-1.5">Pesan <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                                  class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('message') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00] resize-none"
                                  placeholder="Ceritakan pertanyaan atau masalah Anda...">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-[#8d4b00] text-white font-semibold py-3.5 rounded-xl hover:bg-[#6e3900] transition-colors">
                        <span class="material-symbols-outlined">send</span>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
