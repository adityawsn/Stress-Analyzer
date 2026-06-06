<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Menampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request untuk admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Cek kredensial
        $user = \App\Models\User::where('email', $validated['email'])->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        // Cek apakah user adalah admin
        if ($user->role !== 'admin') {
            throw ValidationException::withMessages([
                'email' => 'Akses ditolak. Hanya admin yang dapat login.',
            ]);
        }

        // Login user
        Auth::login($user, $request->boolean('remember'));

        return redirect()->intended('/dashboard');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}
