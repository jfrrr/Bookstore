<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            // For local convenience: generate direct clickable test URL
            if (app()->environment('local')) {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    $token = Password::broker()->createToken($user);
                    $localUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);
                    session()->flash('local_reset_url', $localUrl);
                }
            }

            return back()->with('status', 'Link reset password telah dikirim! Silakan periksa inbox email atau gunakan link pengujian di bawah ini.');
        }

        return back()->withErrors(['email' => 'Alamat email tersebut tidak ditemukan dalam sistem kami.']);
    }

    /**
     * Display the password reset form for the given token.
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'email.required'                 => 'Alamat email wajib diisi.',
            'email.email'                    => 'Format email tidak valid.',
            'password.required'              => 'Password baru wajib diisi.',
            'password.min'                   => 'Password baru minimal harus 8 karakter.',
            'password.confirmed'             => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Password Anda telah berhasil direset! Silakan masuk dengan password baru Anda.');
        }

        return back()->withErrors([
            'email' => 'Token reset password tidak valid atau sudah kedaluwarsa. Silakan ajukan link reset baru.',
        ]);
    }
}
