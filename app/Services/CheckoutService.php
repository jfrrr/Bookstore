<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Menangani seluruh alur transaksi checkout di dalam database transaction.
 * Semua total harga dihitung di sisi server untuk menjamin keamanan data.
 *
 * Urutan Transaksi Database:
 * 1. Validasi keranjang tidak kosong
 * 2. Cek ketersediaan stok seluruh buku
 * 3. Hitung subtotal dan total di server
 * 4. Buat record pesanan (order)
 * 5. Buat rincian pesanan (order items) beserta snapshot harga
 * 6. Kurangi stok buku secara atomik
 * 7. Kosongkan keranjang belanja
 * 8. Commit transaksi
 *
 * Jika terjadi kegagalan di salah satu langkah, seluruh transaksi di-rollback otomatis.
 */
class CheckoutService
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {}

    /**
     * Memproses checkout dan membuat pesanan baru.
     *
     * @param User $user Pengguna yang melakukan pesanan.
     * @param array $data Data validasi penerima & alamat pengiriman.
     * @return Order Objek pesanan yang baru dibuat.
     * @throws \Exception Jika keranjang kosong atau stok buku tidak cukup.
     */
    public function process(User $user, array $data): Order
    {
        $cart = $user->cart()->with('items.book')->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception('Keranjang belanja Anda kosong.');
        }

        return DB::transaction(function () use ($user, $cart, $data) {
            // 1. Verifikasi stok setiap buku dan kunci baris (lockForUpdate) untuk mencegah race condition
            foreach ($cart->items as $item) {
                $book = $item->book()->lockForUpdate()->first();

                if (!$book || $book->status !== 'active') {
                    $bookName = $item->book_title ?? ($book ? $book->title : 'Buku');
                    throw new \Exception("Buku \"{$bookName}\" sudah tidak tersedia.");
                }

                if ($book->stock < $item->quantity) {
                    throw new \Exception("Stok \"{$book->title}\" tidak mencukupi. Tersisa {$book->stock}.");
                }
            }

            // 2. Hitung total harga di sisi server
            $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
            $total = $subtotal;

            // 3. Buat pesanan baru
            $order = $this->orderService->createOrder($user, $data, $subtotal, $total);

            // 4. Buat item pesanan dan kurangi stok buku
            foreach ($cart->items as $item) {
                $book = $item->book;

                $this->orderService->createOrderItem($order, $item);

                // Kurangi stok buku secara atomik
                $book->decrement('stock', $item->quantity);
            }

            // 5. Kosongkan keranjang setelah pesanan berhasil dicatat
            $this->cartService->clearCart($user);

            return $order;
        });
    }
}
