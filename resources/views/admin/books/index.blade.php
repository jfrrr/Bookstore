@extends('layouts.admin')
@section('title', 'Katalog Buku Admin')
@section('page_title', 'Katalog Buku')

@section('content')
<div class="space-y-8">
    {{-- Header & Actions --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <span class="hover:text-amber-400 transition-colors">Manajemen Toko</span>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-400">Katalog Buku</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight flex items-center gap-3">
                Katalog & Inventaris Buku
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 font-sans">
                    {{ $books->total() }} Judul
                </span>
            </h1>
            <p class="text-sm text-slate-400 max-w-2xl">
                Kelola master buku, update stok inventaris, harga jual, sampul buku, dan atur visibilitas penjualan di katalog storefront.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.books.create') }}"
               class="h-11 px-5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-lg shadow-amber-500/20 hover:shadow-amber-400/30 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Buku Baru</span>
            </a>
        </div>
    </div>

    {{-- 2 Metric Cards --}}
    @php
        $totalBooks = \App\Models\Book::count();
        $totalStock = \App\Models\Book::sum('stock');
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        {{-- Card 1: Total Judul --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Koleksi</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ $totalBooks }}</span>
                        <span class="text-xs text-slate-400">Judul</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-[22px]">auto_stories</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs text-emerald-400 font-medium">Katalog Aktif di Etalase</span>
            </div>
        </div>

        {{-- Card 2: Total Stok --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-sky-500/5 rounded-full blur-2xl group-hover:bg-sky-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Unit Stok</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ number_format($totalStock) }}</span>
                        <span class="text-xs text-slate-400">Eksemplar</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400">
                    <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-800/80">
                <span class="text-xs text-slate-400">Fisik Tersedia di Gudang</span>
                <span class="text-xs text-sky-400 font-semibold">Siap Kirim</span>
            </div>
        </div>
    </div>

    {{-- Filter Toolbar & Data Table --}}
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-slate-800 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form action="{{ route('admin.books.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
                {{-- Search Box --}}
                <div class="relative min-w-[260px] flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul atau nama penulis..."
                           class="w-full bg-[#020617] border border-slate-700/80 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all">
                </div>

                {{-- Category Filter --}}
                <select name="category_id" onchange="this.form.submit()"
                        class="bg-[#020617] border border-slate-700/80 rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-amber-400">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-slate-200 text-sm font-medium transition-colors">
                    Filter
                </button>

                @if(request()->anyFilled(['search', 'category_id']))
                    <a href="{{ route('admin.books.index') }}"
                       class="px-3 py-2 rounded-xl bg-slate-800/60 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-xs flex items-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                        <span>Reset</span>
                    </a>
                @endif
            </form>

            <span class="text-xs text-slate-500 shrink-0">Menampilkan {{ $books->count() }} dari {{ $books->total() }} judul</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-[#020617]/50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold">
                        <th class="py-4 px-6">Buku</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Harga</th>
                        <th class="py-4 px-6 text-center">Stok</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm">
                    @forelse($books as $book)
                        <tr class="hover:bg-slate-800/40 transition-colors group">
                            {{-- Cover + Info --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-16 rounded-lg bg-slate-800 border border-slate-700/80 overflow-hidden shrink-0 shadow-md">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-800 text-slate-500">
                                                <span class="material-symbols-outlined text-[20px]">book</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="max-w-xs">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('books.show', $book->slug) }}" target="_blank"
                                               class="font-semibold text-slate-200 hover:text-amber-400 transition-colors line-clamp-1">
                                                {{ $book->title }}
                                            </a>
                                            @if($book->is_bestseller)
                                                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 shrink-0">
                                                    <span class="material-symbols-outlined text-[12px]">local_fire_department</span>
                                                    Bestseller
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">oleh {{ $book->author }}</p>
                                        <span class="text-[10px] text-slate-600 font-mono">ID: #BK-{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs border border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    {{ $book->category->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Price --}}
                            <td class="py-4 px-6 font-mono text-slate-200 font-semibold">
                                Rp {{ number_format($book->price, 0, ',', '.') }}
                            </td>

                            {{-- Stock --}}
                            <td class="py-4 px-6 text-center">
                                @if($book->stock <= 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/30">
                                        Habis
                                    </span>
                                @elseif($book->stock < 5)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        Sisa {{ $book->stock }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                        {{ $book->stock }} unit
                                    </span>
                                @endif
                            </td>


                            {{-- Actions --}}
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('books.show', $book->slug) }}" target="_blank"
                                       class="p-2 rounded-xl text-slate-400 hover:text-sky-400 hover:bg-slate-800 transition-colors"
                                       title="Lihat di Toko">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                       class="p-2 rounded-xl text-slate-400 hover:text-amber-400 hover:bg-slate-800 transition-colors"
                                       title="Edit Buku">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteBookModal({{ $book->id }}, '{{ addslashes($book->title) }}')"
                                            class="p-2 rounded-xl text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-colors"
                                            title="Hapus Buku">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-600 mb-2 block">menu_book</span>
                                Tidak ada buku yang sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($books->hasPages())
            <div class="p-6 border-t border-slate-800 flex justify-between items-center">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Book Confirmation Modal --}}
<div id="deleteBookModal" class="fixed inset-0 z-50 bg-[#020617]/80 backdrop-blur-md hidden items-center justify-center p-4">
    <div class="relative w-full max-w-md bg-[#0f172a] rounded-2xl shadow-2xl border border-slate-800 overflow-hidden flex flex-col my-auto transition-all animate-[scaleIn_0.2s_ease-out]">
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-red-600 via-amber-500 to-red-600"></div>

        <div class="p-6 pb-4 flex items-start justify-between bg-slate-900/60 border-b border-slate-800">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 shrink-0">
                    <span class="material-symbols-outlined text-[26px]">delete_forever</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-100">Hapus Buku</h3>
                    <p class="text-sm text-slate-400 mt-0.5">Konfirmasi penghapusan data buku</p>
                </div>
            </div>
            <button onclick="closeDeleteBookModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="p-4 rounded-xl bg-red-950/20 border border-red-500/20 text-sm text-slate-300">
                Apakah Anda yakin ingin menghapus buku <strong id="deleteBookTitle" class="text-red-200 font-semibold"></strong>?
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Buku akan dihapus secara soft-delete untuk menjaga keutuhan riwayat transaksi pesanan yang telah terjadi sebelumnya.
            </p>
        </div>

        <div class="p-6 pt-3 bg-slate-900/40 border-t border-slate-800 flex items-center justify-end gap-3">
            <button type="button" onclick="closeDeleteBookModal()"
                    class="px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition-colors">
                Batal
            </button>
            <form id="deleteBookForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-semibold text-sm transition-all shadow-lg shadow-red-600/20">
                    Hapus Buku
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteBookModal(id, title) {
    const modal = document.getElementById('deleteBookModal');
    const form = document.getElementById('deleteBookForm');
    const titleEl = document.getElementById('deleteBookTitle');

    form.action = `/admin/books/${id}`;
    titleEl.textContent = title;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteBookModal() {
    const modal = document.getElementById('deleteBookModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
