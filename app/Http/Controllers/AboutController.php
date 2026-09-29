<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Menangani halaman Tentang Kami (About Us) — profil dan informasi toko buku.
 */
class AboutController extends Controller
{
    /**
     * Menampilkan halaman Tentang Kami.
     */
    public function index(): View
    {
        return view('about.index');
    }
}
