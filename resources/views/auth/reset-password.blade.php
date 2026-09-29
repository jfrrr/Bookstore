@extends('layouts.guest')
@section('title', 'Reset Password')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-[#e7e5e4] overflow-hidden">
    <div class="px-8 py-6 border-b border-[#f0e6e0]">
        <h1 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17]">Buat Password Baru</h1>
        <p class="text-[#887364] text-sm mt-1">Masukkan kata sandi baru untuk akun Anda.</p>
    </div>

    <div class="px-8 py-6">
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-base">error</span>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" required readonly
                       class="w-full px-4 py-3 rounded-xl bg-[#f0e6e0]/60 border border-[#dbc2b0] text-[#554336] text-sm cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Password Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="newPassword" required autofocus
                           class="w-full pl-4 pr-12 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('password') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                           placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePasswordVisibility('newPassword', 'newPassIcon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-500 hover:text-[#8d4b00] p-1 flex items-center justify-center transition-colors focus:outline-none"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility">
                        <span id="newPassIcon" class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="newPasswordConfirm" required
                           class="w-full pl-4 pr-12 py-3 rounded-xl bg-[#f6ece6] border border-[#dbc2b0] text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                           placeholder="Ulangi password baru Anda">
                    <button type="button" onclick="togglePasswordVisibility('newPasswordConfirm', 'newPassConfirmIcon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-500 hover:text-[#8d4b00] p-1 flex items-center justify-center transition-colors focus:outline-none"
                            title="Tampilkan / Sembunyikan Password"
                            aria-label="Toggle password visibility">
                        <span id="newPassConfirmIcon" class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-[#8d4b00] text-white font-semibold py-3 rounded-xl hover:bg-[#6e3900] transition-colors flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined text-lg">lock_reset</span>
                <span>Simpan Password Baru</span>
            </button>
        </form>
    </div>

    <div class="px-8 py-5 bg-[#fcf2eb] border-t border-[#f0e6e0] text-center">
        <p class="text-sm text-[#554336]">
            Kembali ke
            <a href="{{ route('login') }}" class="text-[#8d4b00] font-semibold hover:underline">Halaman Login</a>
        </p>
    </div>
</div>
@endsection
