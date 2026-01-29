<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /* =======================
     *  VIEW
     * ======================= */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    /* =======================
     *  LOGIN
     * ======================= */
    public function login(Request $request)
    {
        $request->validate([
            'NRP' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('NRP', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->route('home')
                ->with('success', 'Login berhasil, selamat datang!');
        }

        return back()
            ->withInput($request->only('NRP'))
            ->with('error', 'NRP atau password salah');
    }

    /* =======================
     *  REGISTER
     * ======================= */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'NRP' => 'required|string|unique:users,NRP',
            'tingkat_kesatuan' => 'required|in:Polda,Polres,Polsek',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'nama' => $request->nama,
            'NRP' => $request->NRP,
            'tingkat_kesatuan' => $request->tingkat_kesatuan,
            'password' => Hash::make($request->password),
            'role' => 'user', // 🔒 aman, tidak dari request
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    /* =======================
     *  LOGOUT
     * ======================= */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout');
    }
}
