<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

/**
 * Menangani halaman dashboard admin — menyajikan statistik utama toko dan ringkasan aktivitas terbaru.
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_categories' => Category::count(),
            'total_users'      => User::where('role', 'user')->count(),
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('status', '!=', 'delivered')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'unread_messages'  => ContactMessage::where('status', 'unread')->count(),
            'total_messages'   => ContactMessage::count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentMessages = ContactMessage::latest()
            ->limit(5)
            ->get();

        $orderStatusSummary = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentMessages',
            'orderStatusSummary'
        ));
    }
}
