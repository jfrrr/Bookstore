<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;

/**
 * Menangani halaman utama (beranda) BookStore — menampilkan kategori pilihan, buku terbaru, dan buku bestseller.
 */
class HomeController extends Controller
{
    /**
     * Mengambil data untuk beranda dan mengirimkannya ke tampilan home.index.
     */
    public function index(): View
    {
        // 1. Mengambil kategori aktif yang memiliki buku (maksimal 8)
        $categories = Category::where('status', 'active')
            ->has('books')
            ->withCount(['books' => fn($q) => $q->where('status', 'active')])
            ->limit(8)
            ->get();

        // 2. Mengambil 8 koleksi buku terbaru
        $newArrivals = Book::with('category')
            ->active()
            ->latest()
            ->limit(8)
            ->get();

        // 3. Mengambil buku spotlight berlabel bestseller untuk kartu hero utama
        $spotlightBook = Book::with('category')
            ->active()
            ->where('is_bestseller', true)
            ->latest()
            ->first()
            ?? Book::with('category')->active()->inRandomOrder()->first();

        $featuredBooks = $newArrivals;

        return view('home.index', compact('categories', 'newArrivals', 'spotlightBook', 'featuredBooks'));
    }
}
