<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

/**
 * Pengelolaan pelanggan di panel admin — daftar pengguna/pelanggan terdaftar beserta total pesanannya.
 */
class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', 'user')
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }
}
