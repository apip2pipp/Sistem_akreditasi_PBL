<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function viewLogin()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        return redirect('/dashboard');
    }

    public function login(Request $request)
    {
        // Batasi percobaan login (throttle brute force)
        $key = 'login-attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'username' => ['Terlalu banyak percobaan login. Silakan coba lagi dalam beberapa detik.'],
            ]);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // dd($credentials);

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key); // Reset hitung login jika sukses

            $request->session()->regenerate(); // Regenerate session ID (cegah session fixation)

            return redirect('/dashboard'); // arahkan ke halaman setelah login
        }

        RateLimiter::hit($key, 60); // Tambah hitungan, reset dalam 60 detik

        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); // Hindari CSRF reuse
        return redirect('/login');
    }
}
