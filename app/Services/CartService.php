<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Menangani semua operasi keranjang belanja termasuk menambah, memperbarui, dan menghapus item buku.
 * Seluruh validasi ketersediaan stok buku diproses di sisi server.
 */
class CartService
{
    /**
     * Mengambil keranjang belanja milik user atau membuatnya jika belum ada.
     */
    public function getOrCreateCart(User $user): Cart
    {
        return $user->cart ?? Cart::create(['user_id' => $user->id]);
    }

    /**
     * Menambahkan buku ke dalam keranjang atau menambah jumlahnya jika buku sudah ada di keranjang.
     * Memvalidasi bahwa jumlah yang diminta tidak melebihi sisa stok yang tersedia.
     *
     * @throws \Exception jika stok buku tidak mencukupi.
     */
    public function addItem(User $user, Book $book, int $quantity = 1): CartItem
    {
        if ($book->status !== 'active') {
            throw new \Exception('Buku tidak tersedia.');
        }

        $cart = $this->getOrCreateCart($user);

        $existingItem = $cart->items()->where('book_id', $book->id)->first();

        $newQuantity = $existingItem ? $existingItem->quantity + $quantity : $quantity;

        // Validasi: pastikan jumlah tidak melebihi stok buku di toko
        if ($newQuantity > $book->stock) {
            throw new \Exception("Stok tidak mencukupi. Tersisa {$book->stock} buku.");
        }

        if ($existingItem) {
            $existingItem->update(['quantity' => $newQuantity]);
            return $existingItem->fresh();
        }

        return $cart->items()->create([
            'book_id'  => $book->id,
            'quantity' => $quantity,
            'price'    => $book->price, // Simpan harga buku saat ini
        ]);
    }

    /**
     * Memperbarui kuantitas item buku di dalam keranjang belanja.
     * Memvalidasi ketersediaan stok pada setiap pembaruan.
     *
     * @throws \Exception jika stok tidak mencukupi atau kuantitas kurang dari 1.
     */
    public function updateItem(CartItem $item, int $quantity): CartItem
    {
        if ($quantity < 1) {
            throw new \Exception('Jumlah minimal 1.');
        }

        $book = $item->book;

        if ($quantity > $book->stock) {
            throw new \Exception("Stok tidak mencukupi. Tersisa {$book->stock} buku.");
        }

        $item->update(['quantity' => $quantity]);

        return $item->fresh();
    }

    /**
     * Menghapus satu item buku dari keranjang belanja.
     */
    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    /**
     * Mengosongkan seluruh item dari keranjang user (digunakan setelah checkout berhasil).
     */
    public function clearCart(User $user): void
    {
        if ($cart = $user->cart) {
            $cart->items()->delete();
        }
    }
}
