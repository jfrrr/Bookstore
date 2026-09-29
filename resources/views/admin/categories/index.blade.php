@extends('layouts.admin')
@section('title', 'Kelola Kategori Buku')
@section('page_title', 'Kelola Kategori')

@section('content')
<div class="space-y-8">
    {{-- Header & Actions --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <span class="hover:text-amber-400 transition-colors">Manajemen Toko</span>
                <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
                <span class="text-amber-400">Kategori Buku</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight flex items-center gap-3">
                Kelola Kategori Buku
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 font-sans">
                    {{ $categories->total() }} Terdaftar
                </span>
            </h1>
            <p class="text-sm text-slate-400 max-w-2xl">
                Atur taksonomi dan hierarki kategori buku serta pantau sebaran jumlah koleksi buku di toko secara terpusat.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.categories.create') }}"
               class="h-11 px-5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-lg shadow-amber-500/20 hover:shadow-amber-400/30 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Kategori Baru</span>
            </a>
        </div>
    </div>

    {{-- 2 Metric Cards --}}
    @php
        $totalCategories = \App\Models\Category::count();
        $totalBooksCount = \App\Models\Book::count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        {{-- Card 1 --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Kategori</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ $totalCategories }}</span>
                        <span class="text-xs text-slate-400">Kategori</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-[22px]">folder</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 pt-3 border-t border-slate-800/80">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs text-emerald-400 font-medium">Aktif di Toko Publik</span>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-slate-900/90 backdrop-blur border border-slate-800 rounded-2xl p-5 shadow-xl relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-sky-500/5 rounded-full blur-2xl group-hover:bg-sky-500/10 transition-all"></div>
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Koleksi Terkategori</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-100 font-['Playfair_Display']">{{ number_format($totalBooksCount) }}</span>
                        <span class="text-xs text-slate-400">Buku</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400">
                    <span class="material-symbols-outlined text-[22px]">menu_book</span>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-800/80">
                <span class="text-xs text-slate-400">Rasio Klasifikasi</span>
                <span class="text-xs text-sky-400 font-semibold">100% Terorganisir</span>
            </div>
        </div>
    </div>

    {{-- Table & Search Toolbar --}}
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex-1 max-w-md">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-[18px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama kategori..."
                           class="w-full bg-[#020617] border border-slate-700/80 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all">
                </div>
            </form>
            <div class="flex items-center gap-3">
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs flex items-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                        <span>Reset Filter</span>
                    </a>
                @endif
                <span class="text-xs text-slate-500">Menampilkan {{ $categories->count() }} dari {{ $categories->total() }} data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-[#020617]/50 text-[11px] uppercase tracking-wider text-slate-400 font-semibold">
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Deskripsi</th>
                        <th class="py-4 px-6 text-center">Jumlah Buku</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-800/40 transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 font-bold shrink-0">
                                        <span class="material-symbols-outlined text-[18px]">folder</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-200 block">{{ $category->name }}</span>
                                        <span class="text-[11px] text-slate-500 font-mono">#CAT-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-slate-400 max-w-xs truncate">
                                {{ $category->description ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $category->books_count > 0 ? 'bg-amber-500/10 text-amber-300 border border-amber-500/20' : 'bg-slate-800 text-slate-500' }}">
                                    {{ $category->books_count }} Buku
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="p-2 rounded-xl text-slate-400 hover:text-amber-400 hover:bg-slate-800 transition-colors"
                                       title="Edit Kategori">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->books_count }})"
                                            class="p-2 rounded-xl text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-colors"
                                            title="Hapus Kategori">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-600 mb-2 block">folder_off</span>
                                Tidak ada kategori ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($categories->hasPages())
            <div class="p-6 border-t border-slate-800 flex justify-between items-center">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal Konfirmasi Hapus Kategori (Design reference from modal_konfirmasi_hapus_kategori) --}}
<div id="deleteModal" class="fixed inset-0 z-50 bg-[#020617]/80 backdrop-blur-md hidden items-center justify-center p-4">
    <div class="relative w-full max-w-lg bg-[#0f172a] rounded-2xl shadow-2xl border border-slate-800 overflow-hidden flex flex-col my-auto transition-all animate-[scaleIn_0.2s_ease-out]">
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-red-600 via-amber-500 to-red-600"></div>

        <div class="p-6 pb-4 flex items-start justify-between bg-slate-900/60 border-b border-slate-800">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 shrink-0">
                    <span class="material-symbols-outlined text-[26px]">delete_forever</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-100">Hapus Kategori</h3>
                    <p class="text-sm text-slate-400 mt-0.5">Konfirmasi penghapusan data kategori dari sistem</p>
                </div>
            </div>
            <button onclick="closeDeleteModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="p-4 rounded-xl bg-red-950/20 border border-red-500/20 text-sm text-slate-300">
                Apakah Anda yakin ingin menghapus kategori <strong id="deleteCategoryName" class="text-red-200 font-semibold"></strong>?
            </div>
            <div id="deleteCategoryWarning" class="hidden p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs text-amber-300">
                <span class="material-symbols-outlined text-[16px] inline-block align-middle mr-1">warning</span>
                Kategori ini masih memiliki <strong id="deleteBooksCount"></strong> buku terkait. Kategori tidak dapat dihapus selama masih terdapat buku yang bernaung di bawahnya.
            </div>
        </div>

        <div class="p-6 pt-3 bg-slate-900/40 border-t border-slate-800 flex items-center justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition-colors">
                Batal
            </button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" id="confirmDeleteBtn"
                        class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-semibold text-sm transition-all shadow-lg shadow-red-600/20">
                    Hapus Kategori
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(id, name, booksCount) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const nameEl = document.getElementById('deleteCategoryName');
    const warningEl = document.getElementById('deleteCategoryWarning');
    const booksCountEl = document.getElementById('deleteBooksCount');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    form.action = `/admin/categories/${id}`;
    nameEl.textContent = name;

    if (booksCount > 0) {
        warningEl.classList.remove('hidden');
        booksCountEl.textContent = booksCount;
        confirmBtn.disabled = true;
        confirmBtn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        warningEl.classList.add('hidden');
        confirmBtn.disabled = false;
        confirmBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
