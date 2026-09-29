@extends('layouts.admin')
@section('title', 'Tambah Buku Baru')
@section('page_title', 'Tambah Buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
        <a href="{{ route('admin.books.index') }}" class="hover:text-amber-400 transition-colors">Katalog Buku</a>
        <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
        <span class="text-amber-400">Tambah Buku Baru</span>
    </div>

    {{-- Form Card --}}
    <div class="bg-[#0f172a] rounded-2xl border border-slate-800 shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="p-6 md:p-8 bg-gradient-to-r from-slate-900 via-[#131d38] to-slate-900 border-b border-slate-800 flex items-start justify-between">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-[26px]">add_circle</span>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight">
                        Tambah Judul Buku Baru
                    </h1>
                    <p class="text-sm text-slate-400 mt-1">
                        Lengkapi metadata buku, penetapan harga, kuota stok gudang, dan unggah berkas sampul.
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.books.index') }}"
               class="p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-400 hover:text-slate-100 transition-colors"
               title="Batal & Kembali">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </a>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-sm space-y-1">
                    <div class="font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">error</span>
                        Mohon periksa data formulir:
                    </div>
                    <ul class="list-disc list-inside pl-2 space-y-0.5 text-xs text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">
                {{-- Judul Buku --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-slate-200">
                        Judul Buku <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus
                           placeholder="misal: Clean Code: Panduan Menulis Kode Bersih"
                           class="w-full bg-[#020617] border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">
                </div>

                {{-- Penulis & Kategori Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="author" class="block text-sm font-semibold text-slate-200">
                            Nama Penulis / Pengarang <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" required
                               placeholder="misal: Robert C. Martin"
                               class="w-full bg-[#020617] border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">
                    </div>

                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-semibold text-slate-200">
                            Kategori Buku <span class="text-red-400">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                                class="w-full bg-[#020617] border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Harga & Stok Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="price" class="block text-sm font-semibold text-slate-200">
                            Harga Satuan (Rp) <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold text-sm">Rp</span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="1000"
                                   placeholder="125000"
                                   class="w-full bg-[#020617] border border-slate-700 rounded-xl pl-12 pr-4 py-3 text-sm text-slate-100 placeholder-slate-500 font-mono focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="stock" class="block text-sm font-semibold text-slate-200">
                            Stok Inventaris <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-[18px]">inventory_2</span>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 10) }}" required min="0"
                                   placeholder="50"
                                   class="w-full bg-[#020617] border border-slate-700 rounded-xl pl-12 pr-4 py-3 text-sm text-slate-100 placeholder-slate-500 font-mono focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-slate-200">
                        Sinopsis / Deskripsi Lengkap <span class="text-red-400">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                              placeholder="Tuliskan sinopsis buku, daftar isi ringkas, atau poin-poin penting buku ini..."
                              class="w-full bg-[#020617] border border-slate-700 rounded-xl p-4 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner leading-relaxed">{{ old('description') }}</textarea>
                </div>

                {{-- Upload Sampul Buku --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-200">
                        Berkas Sampul Buku <span class="text-slate-500 text-xs font-normal">(Format: JPG, PNG, WEBP — Maks. 2MB)</span>
                    </label>
                    <div class="border-2 border-dashed border-slate-700 hover:border-amber-500/50 rounded-2xl p-6 text-center transition-colors bg-[#020617]/50 relative">
                        <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/png,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               onchange="previewCover(event)">
                        <div id="uploadPlaceholder" class="space-y-2 pointer-events-none">
                            <span class="material-symbols-outlined text-4xl text-amber-400">cloud_upload</span>
                            <p class="text-sm text-slate-300 font-medium">Klik atau seret gambar sampul ke area ini</p>
                            <p class="text-xs text-slate-500">Rasio standar buku 3:4 direkomendasikan</p>
                        </div>
                        <div id="previewContainer" class="hidden flex-col items-center gap-3">
                            <img id="coverPreview" src="" alt="Pratinjau Sampul" class="h-44 w-32 object-cover rounded-xl shadow-lg border border-slate-700">
                            <span class="text-xs text-amber-400 font-medium">Klik untuk mengganti gambar</span>
                        </div>
                    </div>
                </div>



                {{-- Bestseller Spotlight Toggle --}}
                <div class="p-4 rounded-xl bg-[#020617] border border-amber-500/30 hover:border-amber-400 transition-all">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }}
                               class="accent-amber-500 w-5 h-5 rounded mt-0.5">
                        <div>
                            <span class="text-sm font-semibold text-amber-300 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">local_fire_department</span>
                                Jadikan Buku Bestseller Spotlight di Halaman Utama
                            </span>
                            <span class="text-xs text-slate-400 mt-0.5 block">
                                Jika dicentang, buku ini akan langsung dipasang di kartu sorotan "Bestseller Bulan Ini" pada bagian banner beranda toko.
                            </span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="pt-6 border-t border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.books.index') }}"
                   class="px-5 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-lg shadow-amber-500/20 hover:shadow-amber-400/30 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    <span>Simpan Buku</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewCover(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('coverPreview').src = e.target.result;
            document.getElementById('previewContainer').classList.remove('hidden');
            document.getElementById('previewContainer').classList.add('flex');
            document.getElementById('uploadPlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
