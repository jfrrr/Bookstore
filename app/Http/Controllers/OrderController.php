<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

/**
 * Menangani pesanan pelanggan — melihat riwayat belanja, status pesanan, dan konfirmasi setelah checkout.
 */
class OrderController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan milik pelanggan yang sedang login (paginasi 10 item).
     */
    public function index(): View
    {
        $orders = auth()->user()->orders()
            ->with('items.book')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan rincian pesanan spesifik beserta status pesanan (Belum Selesai / Selesai).
     */
    public function show(Order $order): View
    {
        // Keamanan: Cegah pengguna melihat pesanan milik akun orang lain
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.book');

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan halaman ucapan terima kasih dan konfirmasi tepat setelah pembeli menekan tombol 'Buat Pesanan'.
     */
    public function success(Order $order): View
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang dapat membuka halaman sukses ini
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items');

        return view('checkout.success', compact('order'));
    }
}
