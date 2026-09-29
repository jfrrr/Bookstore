@extends('layouts.admin')
@section('title', 'Edit Kategori: ' . $category->name)
@section('page_title', 'Edit Kategori')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-amber-400 transition-colors">Kategori</a>
        <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
        <span class="text-slate-300">{{ $category->name }}</span>
        <span class="material-symbols-outlined text-[14px] text-slate-600">chevron_right</span>
        <span class="text-amber-400">Edit Kategori</span>
    </div>

    {{-- Form Card Stage --}}
    <div class="bg-[#0f172a] rounded-2xl border border-slate-800 shadow-2xl overflow-hidden">
        {{-- Card Header --}}
        <div class="p-6 md:p-8 bg-gradient-to-r from-slate-900 via-[#131d38] to-slate-900 border-b border-slate-800 flex items-start justify-between">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-[26px]">edit_note</span>
                </div>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h1 class="text-xl md:text-2xl font-bold text-slate-100 font-['Playfair_Display'] tracking-tight">
                            Edit Kategori: {{ $category->name }}
                        </h1>
                        <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-800 text-slate-400 border border-slate-700">
                            #CAT-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-400 mt-1">
                        Perbarui nama dan deskripsi kategori buku.
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.categories.index') }}"
               class="p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-400 hover:text-slate-100 transition-colors"
               title="Kembali ke Daftar">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </a>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            @method('PUT')

            {{-- Validation Errors Banner --}}
            @if ($errors->any())
                <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-sm space-y-1">
                    <div class="font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">error</span>
                        Terjadi kesalahan pengisian form:
                    </div>
                    <ul class="list-disc list-inside pl-2 space-y-0.5 text-xs text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">
                {{-- Nama Kategori --}}
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-slate-200">
                        Nama Kategori <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                           class="w-full bg-[#020617] border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-slate-200">
                        Deskripsi Kategori <span class="text-slate-500 text-xs font-normal">(Opsional)</span>
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full bg-[#020617] border border-slate-700 rounded-xl p-4 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400/20 transition-all shadow-inner">{{ old('description', $category->description) }}</textarea>
                </div>



                {{-- Info Buku Terhubung --}}
                <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-amber-400">menu_book</span>
                        <span class="text-sm text-slate-300">Buku terdaftar pada kategori ini</span>
                    </div>
                    <span class="text-sm font-bold text-amber-300 font-mono">
                        {{ $category->books()->count() }} Buku
                    </span>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="pt-6 border-t border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-5 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-lg shadow-amber-500/20 hover:shadow-amber-400/30 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    <span>Perbarui Kategori</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
