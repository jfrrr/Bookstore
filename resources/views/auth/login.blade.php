@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-[#e7e5e4] overflow-hidden">
    <div class="px-8 py-6 border-b border-[#f0e6e0]">
        <h1 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17]">Selamat Datang Kembali</h1>
        <p class="text-[#887364] text-sm mt-1">Masuk ke akun BookStore Anda</p>
    </div>

    <div class="px-8 py-6">
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-base text-emerald-600">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-base">error</span>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('email') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                       placeholder="email@contoh.com">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-sm font-medium text-[#554336]">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#8d4b00] hover:underline">
                        Lupa Password?
                    </a>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="loginPassword" required
                           class="w-full pl-4 pr-12 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('password') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                           placeholder="Masukkan password">
                    <button type="button" onclick="togglePasswordVisibility('loginPassword', 'loginPassIcon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-500 hover:text-[#8d4b00] p-1 flex items-center justify-center transition-colors focus:outline-none"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility">
                        <span id="loginPassIcon" class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="rounded accent-[#8d4b00]">
                <label for="remember" class="text-sm text-[#554336]">Ingat saya</label>
            </div>

            <button type="submit"
                    class="w-full bg-[#8d4b00] text-white font-semibold py-3 rounded-xl hover:bg-[#6e3900] transition-colors">
                Masuk
            </button>
        </form>
    </div>

    <div class="px-8 py-5 bg-[#fcf2eb] border-t border-[#f0e6e0] text-center">
        <p class="text-sm text-[#554336]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#8d4b00] font-semibold hover:underline">Daftar Sekarang</a>
        </p>
    </div>
</div>
@endsection
