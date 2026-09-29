<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menangani alur checkout — menampilkan formulir pemesanan dan memproses pembuatan pesanan COD.
 */
class CheckoutController extends Controller
{
    public function __construct(private CheckoutService $checkoutService) {}

    /**
     * Menampilkan halaman checkout dan rincian ringkasan belanja sebelum bayar.
     */
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();
        $cart = $user->cart()->with('items.book')->first();

        // Jika keranjang belanja kosong, arahkan kembali ke halaman keranjang
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = $cart->total();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    /**
     * Memproses data formulir checkout dan membuat pesanan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input data penerima pesanan
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'phone'            => ['required', 'string', 'max:20'],
            'delivery_address' => ['required', 'string', 'min:10'],
        ], [
            'name.required'             => 'Nama penerima wajib diisi.',
            'phone.required'            => 'Nomor telepon wajib diisi.',
            'delivery_address.required' => 'Alamat pengiriman wajib diisi.',
            'delivery_address.min'      => 'Alamat pengiriman terlalu singkat.',
        ]);

        try {
            // Memanggil CheckoutService untuk memotong stok dan membuat record order
            $order = $this->checkoutService->process(auth()->user(), $validated);

            return redirect()->route('orders.success', $order)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
