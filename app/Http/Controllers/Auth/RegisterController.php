<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Hanya bisa diakses oleh tamu (belum login)
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Tampilkan form registrasi
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Validasi input registrasi
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', 'in:pasien,paramedis,dokter,k3,sdm'],
        ]);
    }

    /**
     * Membuat user baru setelah validasi
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);
    }

    /**
     * Proses registrasi user (override Laravel default)
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($this->create($request->all())));

        // Tidak login otomatis
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
