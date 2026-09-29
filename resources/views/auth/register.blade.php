@extends('layouts.guest')
@section('title', 'Daftar Akun')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-[#e7e5e4] overflow-hidden">
    <div class="px-8 py-6 border-b border-[#f0e6e0]">
        <h1 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17]">Buat Akun Baru</h1>
        <p class="text-[#887364] text-sm mt-1">Bergabung dengan komunitas pecinta buku BookStore</p>
    </div>

    <div class="px-8 py-6">
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('name') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                       placeholder="Masukkan nama lengkap Anda">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('email') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                       placeholder="email@contoh.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="regPassword" required
                           class="w-full pl-4 pr-12 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('password') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                           placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePasswordVisibility('regPassword', 'regPassIcon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-500 hover:text-[#8d4b00] p-1 flex items-center justify-center transition-colors focus:outline-none"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility">
                        <span id="regPassIcon" class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="regPasswordConfirm" required
                           class="w-full pl-4 pr-12 py-3 rounded-xl bg-[#f6ece6] border border-[#dbc2b0] text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                           placeholder="Ulangi password Anda">
                    <button type="button" onclick="togglePasswordVisibility('regPasswordConfirm', 'regConfirmIcon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-500 hover:text-[#8d4b00] p-1 flex items-center justify-center transition-colors focus:outline-none"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility">
                        <span id="regConfirmIcon" class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-[#8d4b00] text-white font-semibold py-3 rounded-xl hover:bg-[#6e3900] transition-colors mt-2">
                Buat Akun
            </button>
        </form>
    </div>

    <div class="px-8 py-5 bg-[#fcf2eb] border-t border-[#f0e6e0] text-center">
        <p class="text-sm text-[#554336]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#8d4b00] font-semibold hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
