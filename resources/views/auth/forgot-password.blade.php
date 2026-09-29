@extends('layouts.guest')
@section('title', 'Lupa Password')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-[#e7e5e4] overflow-hidden">
    <div class="px-8 py-6 border-b border-[#f0e6e0]">
        <h1 class="font-['Playfair_Display'] font-bold text-2xl text-[#1f1b17]">Lupa Password Anda?</h1>
        <p class="text-[#887364] text-sm mt-1">Masukkan alamat email Anda untuk menerima link reset password.</p>
    </div>

    <div class="px-8 py-6">
        {{-- Flash Error --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-base">error</span>
            {{ $errors->first() }}
        </div>
        @endif

        {{-- Flash Success / Status --}}
        @if(session('status'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl mb-5 text-sm space-y-2">
            <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-emerald-600 text-lg mt-0.5">check_circle</span>
                <p class="font-medium">{{ session('status') }}</p>
            </div>
            @if(session('local_reset_url'))
            <div class="mt-3 pt-3 border-t border-emerald-200/80 bg-emerald-100/60 p-3 rounded-lg text-xs">
                <p class="font-semibold text-emerald-900 mb-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">developer_mode</span>
                    Pintasan Mode Lokal:
                </p>
                <p class="text-emerald-800 mb-2">Karena berjalan di server lokal, Anda dapat langsung mengklik tautan reset di bawah:</p>
                <a href="{{ session('local_reset_url') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#8d4b00] text-white font-semibold hover:bg-[#6e3900] transition-colors shadow-xs">
                    <span>Buka Form Reset Password</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            @endif
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[#554336] mb-1.5">Alamat Email Terdaftar</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-[#f6ece6] border {{ $errors->has('email') ? 'border-red-400' : 'border-[#dbc2b0]' }} text-[#1f1b17] text-sm focus:outline-none focus:ring-2 focus:ring-[#8d4b00]/30 focus:border-[#8d4b00]"
                       placeholder="email@contoh.com">
            </div>

            <button type="submit"
                    class="w-full bg-[#8d4b00] text-white font-semibold py-3 rounded-xl hover:bg-[#6e3900] transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">mail</span>
                <span>Kirim Link Reset Password</span>
            </button>
        </form>
    </div>

    <div class="px-8 py-5 bg-[#fcf2eb] border-t border-[#f0e6e0] text-center">
        <p class="text-sm text-[#554336]">
            Ingat password Anda?
            <a href="{{ route('login') }}" class="text-[#8d4b00] font-semibold hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
