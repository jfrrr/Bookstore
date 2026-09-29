<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Handles new user registration.
 * Role is always forced to 'user' server-side — never trust user input for role.
 */
class RegisterController extends Controller
{
    public function showForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // always force role = user on registration
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Selamat datang di BookStore, ' . $user->name . '!');
    }
}
