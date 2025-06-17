<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Tampilkan form login
    public function login()
    {
        return view('auth.login');
    }

    // Proses login
    public function logincek(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // 1. Coba login menggunakan username
        if (Auth::attempt(['username' => $login, 'password' => $password])) {
            return $this->authenticated($request, Auth::user());
        }

        // 2. Jika gagal, coba menggunakan name
        if (Auth::attempt(['name' => $login, 'password' => $password])) {
            return $this->authenticated($request, Auth::user());
        }

        // 3. Gagal login
        return back()->withErrors([
            'login' => 'Username / Nama dan password salah.',
        ]);
    }

    // Arahkan user setelah login berdasarkan role
    protected function authenticated(Request $request, $user)
    {
        $request->session()->regenerate();

        switch ($user->role) {
            case 'pasien':
                return redirect('/dashboard');
            case 'paramedis':
                return redirect('/paramedis/dashboard');
            case 'dokter':
                return redirect('/dokter/dashboard');
            case 'k3':
                return redirect('/k3/dashboard');
            case 'sdm':
                return redirect('/sdm/dashboard');
            default:
                Auth::logout(); // Jika role tidak dikenali
                return redirect('/login')->withErrors(['login' => 'Role tidak dikenali.']);
        }
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
