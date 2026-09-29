<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menangani halaman publik buku — katalog pencarian/filter dan halaman detail buku.
 */
class BookController extends Controller
{
    /**
     * Menampilkan katalog buku dengan fitur pencarian, filter kategori, dan pengurutan.
     */
    public function index(Request $request): View
    {
        $query = Book::with('category')->active();

        // 1. Pencarian berdasarkan judul atau penulis buku
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // 2. Filter berdasarkan kategori buku
        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

        // 3. Pengurutan buku (Terbaru, Judul A-Z/Z-A, Harga Terendah/Tertinggi)
        match ($request->input('sort', 'newest')) {
            'title_asc'   => $query->orderBy('title', 'asc'),
            'title_desc'  => $query->orderBy('title', 'desc'),
            'price_asc'   => $query->orderBy('price', 'asc'),
            'price_desc'  => $query->orderBy('price', 'desc'),
            default       => $query->latest(),
        };

        // Membagi data buku menjadi 12 item per halaman (paginasi)
        $books = $query->paginate(12)->withQueryString();

        // Mengambil daftar kategori aktif yang memiliki buku beserta jumlahnya
        $categories = Category::where('status', 'active')
            ->has('books')
            ->withCount(['books' => fn($q) => $q->where('status', 'active')])
            ->get();

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Menampilkan halaman detail untuk satu buku tertentu.
     */
    public function show(Book $book): View
    {
        // Tolak dengan error 404 jika status buku tidak aktif
        abort_if($book->status !== 'active', 404);

        $book->load('category');

        // Mengambil hingga 4 rekomendasi buku terkait dari kategori yang sama
        $relatedBooks = Book::with('category')
            ->active()
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit(4)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }
}
