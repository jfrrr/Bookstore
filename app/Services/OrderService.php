<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * Menangani logika pembuatan pesanan, termasuk pembuatan nomor invoice unik
 * dan snapshot data buku untuk menjaga keakuratan riwayat transaksi.
 */
class OrderService
{
    /**
     * Menghasilkan nomor pesanan unik yang mudah dibaca.
     * Format: BS-YYYYMMDD-XXXX (Contoh: BS-20260919-0001)
     */
    public function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "BS-{$date}-";

        // Cari nomor pesanan terakhir hari ini lalu tambahkan +1
        $last = Order::where('order_number', 'like', "{$prefix}%")
            ->orderBy('order_number', 'desc')
            ->value('order_number');

        $sequence = $last ? (int) substr($last, -4) + 1 : 1;

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Membuat record pesanan baru dari data checkout pelanggan.
     */
    public function createOrder(User $user, array $data, float $subtotal, float $total): Order
    {
        return Order::create([
            'user_id'         => $user->id,
            'order_number'    => $this->generateOrderNumber(),
            'customer_name'   => $data['name'],
            'phone'           => $data['phone'],
            'delivery_address' => $data['delivery_address'],
            'payment_method'  => $data['payment_method'] ?? 'cod',
            'status'          => 'pending',
            'subtotal'        => $subtotal,
            'total'           => $total,
        ]);
    }

    /**
     * Membuat item pesanan dengan snapshot data lengkap saat transaksi terjadi.
     * Hal ini memastikan data pesanan historis tetap akurat meskipun data buku diubah/dihapus nantinya.
     */
    public function createOrderItem(Order $order, CartItem $cartItem): OrderItem
    {
        $book = $cartItem->book;

        return OrderItem::create([
            'order_id'   => $order->id,
            'book_id'    => $book->id,
            'book_title' => $book->title,   // Snapshot judul buku saat dibeli
            'author'     => $book->author,  // Snapshot nama penulis
            'price'      => $cartItem->price, // Snapshot harga beli buku
            'quantity'   => $cartItem->quantity,
            'subtotal'   => $cartItem->price * $cartItem->quantity,
        ]);
    }
}
