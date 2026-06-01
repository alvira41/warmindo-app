<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // TAMPILKAN HALAMAN LOGIN
    // =========================
    public function showLogin()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        // =========================
        // CEK LOCK LOGIN
        // =========================
        if (session()->has('login_lock_time')) {
            $lockTime = session('login_lock_time');

            if (now()->lessThan($lockTime)) {
                $minutes = now()->diffInMinutes($lockTime);

                return back()->with('error', "Akun dikunci. Coba lagi dalam $minutes menit");
            } else {
                // reset kalau waktu lock habis
                session()->forget(['login_attempts', 'login_lock_time']);
            }
        }

        // =========================
        // VALIDASI INPUT
        // =========================
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // =========================
        // CEK USER
        // =========================
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            // tambah percobaan login
            $attempts = session('login_attempts', 0) + 1;
            session(['login_attempts' => $attempts]);

            // kalau gagal 3x → lock 3 jam
            if ($attempts >= 3) {
                session([
                    'login_lock_time' => now()->addHours(3)
                ]);

                return back()->with('error', 'Akun dikunci selama 3 jam');
            }

            return back()->with('error', "Login salah ($attempts/3)");
        }

        // =========================
        // RESET LOGIN ATTEMPT
        // =========================
        session()->forget(['login_attempts', 'login_lock_time']);

        // =========================
        // SECURITY SESSION
        // =========================
        $request->session()->regenerate();

        // =========================
        // SIMPAN SESSION USER
        // =========================
        session([
            'user_id' => $user->id,
            'role' => $user->role,
            'name' => $user->name
        ]);

        // =========================
        // REDIRECT SESUAI ROLE
        // =========================
        if ($user->role === 'admin') {
            return redirect()->route('admin.menu');
        }

        if ($user->role === 'kasir') {
            return redirect()->route('admin.dashboard');
        }

        // fallback
        return redirect('/');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        session()->flush();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
