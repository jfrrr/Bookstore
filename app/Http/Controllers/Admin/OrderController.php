<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Pengelolaan pesanan di panel admin — melihat daftar pesanan, detail pemesanan, dan memperbarui status pesanan.
 */
class OrderController extends Controller
{
    /** Transisi status yang valid: Belum Selesai (pending) dan Selesai (delivered). */
    private const ALLOWED_TRANSITIONS = [
        'pending'    => ['delivered'],
        'confirmed'  => ['delivered'],
        'processing' => ['delivered'],
        'shipped'    => ['delivered'],
        'delivered'  => ['pending'],
        'cancelled'  => ['pending'],
    ];

    public function index(Request $request): View
    {
        $query = Order::with('user');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'delivered' || $status === 'selesai') {
                $query->where('status', 'delivered');
            } elseif ($status === 'pending' || $status === 'belum_selesai') {
                $query->where('status', '!=', 'delivered');
            }
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.book']);
        $allowedTransitions = self::ALLOWED_TRANSITIONS[$order->status] ?? ['delivered'];

        return view('admin.orders.show', compact('order', 'allowedTransitions'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,delivered,selesai,belum_selesai'],
        ]);

        $inputStatus = $request->input('status');
        $newStatus = in_array($inputStatus, ['delivered', 'selesai']) ? 'delivered' : 'pending';

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
