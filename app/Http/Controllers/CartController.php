<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menangani keranjang belanja pelanggan — melihat isi, menambah buku, memperbarui jumlah, dan menghapus item.
 */
class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    /**
     * Menampilkan daftar buku di dalam keranjang belanja pelanggan beserta total harga.
     */
    public function index(): View
    {
        $cart = auth()->user()->cart()->with('items.book.category')->first();
        $total = $cart ? $cart->total() : 0;

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Menambahkan buku ke dalam keranjang belanja.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'book_id'  => ['required', 'exists:books,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $book = Book::findOrFail($request->book_id);

        try {
            $this->cartService->addItem(auth()->user(), $book, (int) $request->quantity);
            return back()->with('success', "\"{$book->title}\" berhasil ditambahkan ke keranjang.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Memperbarui jumlah (kuantitas) buku di keranjang belanja.
     */
    public function update(Request $request, CartItem $item): RedirectResponse
    {
        // Keamanan: Pastikan item keranjang benar-benar milik pengguna yang sedang login
        abort_if($item->cart->user_id !== auth()->id(), 403);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->cartService->updateItem($item, (int) $request->quantity);
            return back()->with('success', 'Keranjang berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menghapus satu item buku dari keranjang belanja.
     */
    public function destroy(CartItem $item): RedirectResponse
    {
        // Keamanan: Pastikan item keranjang benar-benar milik pengguna yang sedang login
        abort_if($item->cart->user_id !== auth()->id(), 403);

        $this->cartService->removeItem($item);

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
