@extends('layouts.admin')
@section('title', 'Detail Pesan: ' . $message->subject)
@section('page_title', 'Detail Pesan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Breadcrumbs & Header --}}
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400 transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <a href="{{ route('admin.messages.index') }}" class="hover:text-amber-400 transition-colors">Pesan Kontak</a>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-400">Detail</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-100 font-['Playfair_Display']">
                Detail Pesan Kontak
            </h1>
        </div>

        <a href="{{ route('admin.messages.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 text-xs font-semibold transition-all">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Message Main Card --}}
    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        {{-- Header info: sender & timestamp --}}
        <div class="p-6 md:p-8 border-b border-slate-800 bg-slate-950/40">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 font-bold text-lg shrink-0">
                        {{ strtoupper(substr($message->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h2 class="text-lg font-bold text-slate-100">{{ $message->name }}</h2>
                            @if($message->status === 'unread')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    Belum Dibaca
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    Sudah Dibaca
                                </span>
                            @endif
                        </div>
                        <a href="mailto:{{ $message->email }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-[14px]">mail</span>
                            {{ $message->email }}
                        </a>
                    </div>
                </div>

                <div class="text-left md:text-right text-xs text-slate-400 space-y-1">
                    <div>
                        <span class="text-slate-500">Dikirim:</span>
                        <span class="text-slate-300 font-medium">{{ $message->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="text-[11px] text-slate-500">
                        ({{ $message->created_at->diffForHumans() }})
                    </div>
                </div>
            </div>
        </div>

        {{-- Subject and Message Content --}}
        <div class="p-6 md:p-8 space-y-6">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Subjek</span>
                <h3 class="text-xl font-bold text-slate-100 font-['Playfair_Display']">
                    {{ $message->subject }}
                </h3>
            </div>

            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Isi Pesan</span>
                <div class="bg-slate-950/60 border border-slate-800/80 rounded-xl p-5 md:p-6 text-slate-200 text-sm leading-relaxed whitespace-pre-line font-sans">
                    {{ $message->message }}
                </div>
            </div>
        </div>

        {{-- Bottom Actions --}}
        <div class="p-6 border-t border-slate-800 bg-slate-950/20 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                {{-- Balas via Email --}}
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . $message->subject) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">reply</span>
                    Balas via Email ({{ $message->email }})
                </a>

                {{-- Toggle Read/Unread --}}
                <form action="{{ route('admin.messages.toggle-read', $message) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold border border-slate-700/50 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">
                            {{ $message->status === 'unread' ? 'mark_email_read' : 'mark_email_unread' }}
                        </span>
                        {{ $message->status === 'unread' ? 'Tandai Sudah Dibaca' : 'Tandai Belum Dibaca' }}
                    </button>
                </form>
            </div>

            {{-- Delete Button --}}
            <form action="{{ route('admin.messages.destroy', $message) }}"
                  method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 hover:border-red-500/40 text-xs font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    Hapus Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
