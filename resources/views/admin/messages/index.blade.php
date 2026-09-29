@extends('layouts.admin')
@section('title', 'Pesan Kontak Masuk')
@section('page_title', 'Pesan Kontak')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400 transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-400">Pesan Kontak</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight flex items-center gap-3">
                Pesan Kontak Masuk
                @if($unreadCount > 0)
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30 font-sans">
                        {{ $unreadCount }} Belum Dibaca
                    </span>
                @endif
            </h1>
            <p class="text-sm text-slate-400 max-w-2xl">
                Kelola dan pantau seluruh pesan atau pertanyaan yang dikirimkan oleh pengunjung melalui formulir Kontak Kami.
            </p>
        </div>
    </div>

    {{-- Metrics Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {{-- Total Messages --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Pesan</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ $totalCount }}</span>
                        <span class="text-xs text-slate-400">Pesan Masuk</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400">
                    <span class="material-symbols-outlined text-[22px]">mail</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="text-xs text-slate-400">Total formulir terkirim</span>
            </div>
        </div>

        {{-- Unread Messages --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Belum Dibaca</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-amber-400 font-['Playfair_Display']">{{ $unreadCount }}</span>
                        <span class="text-xs text-amber-300/80">Perlu Tindakan</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-[22px]">mark_email_unread</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                @if($unreadCount > 0)
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-xs text-amber-400 font-medium">Ada pesan yang belum dicek</span>
                @else
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-xs text-emerald-400 font-medium">Semua pesan sudah dibaca</span>
                @endif
            </div>
        </div>

        {{-- Read Messages --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Sudah Dibaca</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-emerald-400 font-['Playfair_Display']">{{ $totalCount - $unreadCount }}</span>
                        <span class="text-xs text-slate-400">Pesan Selesai</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <span class="material-symbols-outlined text-[22px]">mark_email_read</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="text-xs text-slate-400">Pesan telah diarsipkan</span>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">
        {{-- Status Filter Tabs --}}
        <div class="flex items-center gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('admin.messages.index') }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-colors shrink-0 {{ !request('status') ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                Semua Pesan ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-colors shrink-0 {{ request('status') === 'unread' ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                Belum Dibaca ({{ $unreadCount }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-colors shrink-0 {{ request('status') === 'read' ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                Sudah Dibaca ({{ $totalCount - $unreadCount }})
            </a>
        </div>

        {{-- Search Input --}}
        <form method="GET" action="{{ route('admin.messages.index') }}" class="w-full md:w-80 flex items-center gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-lg">search</span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari pengirim, subjek, pesan..."
                       class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-amber-500 transition-colors">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.messages.index', request('status') ? ['status' => request('status')] : []) }}"
                   class="px-2.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <span class="text-sm font-semibold text-slate-200">Daftar Formulir Kontak</span>
            <span class="text-xs text-slate-500">Menampilkan {{ $messages->count() }} dari {{ $messages->total() }} pesan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800/80 text-[11px] font-semibold text-slate-400 uppercase tracking-wider bg-slate-950/40">
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Pengirim</th>
                        <th class="py-4 px-6">Subjek & Pesan</th>
                        <th class="py-4 px-6">Waktu Dikirim</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm">
                    @forelse($messages as $msg)
                    <tr class="hover:bg-slate-800/30 transition-colors group {{ $msg->status === 'unread' ? 'bg-amber-500/[0.02]' : '' }}">
                        {{-- Status Badge --}}
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($msg->status === 'unread')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                    Belum Dibaca
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 text-slate-400 border border-slate-700/50">
                                    Sudah Dibaca
                                </span>
                            @endif
                        </td>

                        {{-- Sender Info --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700/50 flex items-center justify-center text-slate-300 font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-medium text-slate-200 group-hover:text-amber-400 transition-colors truncate">
                                        {{ $msg->name }}
                                    </div>
                                    <a href="mailto:{{ $msg->email }}" class="text-xs text-slate-400 hover:text-amber-400 flex items-center gap-1 mt-0.5 transition-colors">
                                        <span class="material-symbols-outlined text-[12px]">mail</span>
                                        {{ $msg->email }}
                                    </a>
                                </div>
                            </div>
                        </td>

                        {{-- Subject & Snippet --}}
                        <td class="py-4 px-6 max-w-xs md:max-w-md">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="block">
                                <div class="font-semibold text-slate-200 hover:text-amber-400 transition-colors truncate {{ $msg->status === 'unread' ? 'text-amber-200 font-bold' : '' }}">
                                    {{ $msg->subject }}
                                </div>
                                <div class="text-xs text-slate-400 line-clamp-1 mt-0.5">
                                    {{ Str::limit($msg->message, 80) }}
                                </div>
                            </a>
                        </td>

                        {{-- Timestamp --}}
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="text-slate-300 text-xs font-medium">
                                {{ $msg->created_at->diffForHumans() }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                {{ $msg->created_at->translatedFormat('d M Y, H:i') }}
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="py-4 px-6 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                {{-- View Detail --}}
                                <a href="{{ route('admin.messages.show', $msg) }}"
                                   title="Lihat Detail Pesan"
                                   class="p-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-amber-500/10 hover:text-amber-400 border border-slate-700/50 hover:border-amber-500/30 transition-all flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>

                                {{-- Toggle Read Status --}}
                                <form action="{{ route('admin.messages.toggle-read', $msg) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            title="{{ $msg->status === 'unread' ? 'Tandai Sudah Dibaca' : 'Tandai Belum Dibaca' }}"
                                            class="p-2 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 border border-slate-700/50 transition-all flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[18px]">
                                            {{ $msg->status === 'unread' ? 'mark_email_read' : 'mark_email_unread' }}
                                        </span>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.messages.destroy', $msg) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            title="Hapus Pesan"
                                            class="p-2 rounded-xl bg-slate-800 text-slate-400 hover:bg-red-500/10 hover:text-red-400 border border-slate-700/50 hover:border-red-500/30 transition-all flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 px-6 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <span class="material-symbols-outlined text-4xl text-slate-600">inbox</span>
                                <p class="text-sm">Tidak ada pesan kontak yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
        <div class="p-6 border-t border-slate-800">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
