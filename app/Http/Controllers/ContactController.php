<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menangani halaman kontak — menampilkan formulir pesan dan menyimpan pesan pengunjung ke database.
 */
class ContactController extends Controller
{
    /**
     * Menampilkan halaman formulir Kontak Kami.
     */
    public function index(): View
    {
        return view('contact.index');
    }

    /**
     * Memvalidasi dan menyimpan pesan yang dikirim oleh pengunjung toko.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi kolom formulir kontak
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan minimal 10 karakter.',
        ]);

        // Simpan pesan ke tabel contact_messages
        ContactMessage::create($validated);

        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera merespons.');
    }
}
