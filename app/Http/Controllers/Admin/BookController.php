<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Pengelolaan buku di panel admin — operasi CRUD dengan penanganan upload cover buku yang aman.
 */
class BookController extends Controller
{
    public function index(Request $request): View
    {
        $query = Book::with('category');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $books = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], $this->validationMessages());

        $validated['status'] = 'active';
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
        $validated['is_bestseller'] = $request->boolean('is_bestseller');

        if ($validated['is_bestseller']) {
            Book::where('is_bestseller', true)->update(['is_bestseller' => false]);
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book): View
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], $this->validationMessages());

        $validated['status'] = $book->status ?? 'active';

        $validated['is_bestseller'] = $request->boolean('is_bestseller');

        if ($validated['is_bestseller']) {
            Book::where('is_bestseller', true)->where('id', '!=', $book->id)->update(['is_bestseller' => false]);
        }

        if ($request->hasFile('cover_image')) {
            // Hapus file cover lama dari disk jika ada
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')
                ->store('covers', 'public');
        }

        // Buat ulang slug jika judul buku diubah
        if ($validated['title'] !== $book->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        // Hapus secara aman (soft-delete) untuk menjaga integritas data riwayat pesanan
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /** Pesan error validasi bersama untuk operasi tambah dan ubah buku. */
    private function validationMessages(): array
    {
        return [
            'title.required'       => 'Judul buku wajib diisi.',
            'author.required'      => 'Nama penulis wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'description.required' => 'Deskripsi buku wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'stock.required'       => 'Stok wajib diisi.',
            'stock.min'            => 'Stok tidak boleh negatif.',
            'cover_image.image'    => 'File harus berupa gambar.',
            'cover_image.mimes'    => 'Format gambar yang diizinkan: jpg, jpeg, png, webp.',
            'cover_image.max'      => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
