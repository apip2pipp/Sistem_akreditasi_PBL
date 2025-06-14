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
        return redirect('/dashbodard');
    }

    public function login(Request $request)
    {
        // Batasi percobaan login (throttle brute force)
        $key = 'login-attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
           return response()->json([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam beberapa detik.'
            ], 429);
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
                return response()->json([
                'status' => 'success',
                'message' => 'The username and password is correct',
                'redirect' => url('/dashboard')
            ]);

            // return redirect('/dashboard')->with('success', 'The username and password is correct'); // arahkan ke halaman setelah login
        }

        RateLimiter::hit($key, 60); // Tambah hitungan, reset dalam 60 detik

        return response()->json([
        'status' => 'error',
        'message' => 'The username and password your entered is incorrect'
    ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); // Hindari CSRF reuse
        return redirect('/login');
    }
}
