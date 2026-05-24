<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaLoginController extends Controller
{
    /**
     * Show the mahasiswa login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->isMahasiswa()) {
            return redirect('/dashboard/mahasiswa');
        }

        return view('auth.mahasiswa-login');
    }

    /**
     * Handle mahasiswa login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'npm' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find mahasiswa by NPM
        $mahasiswa = Mahasiswa::where('npm', $request->npm)->first();

        if (!$mahasiswa) {
            return back()->withErrors([
                'npm' => 'NPM tidak ditemukan.',
            ])->withInput($request->only('npm'));
        }

        // Attempt login using the associated user account
        $user = $mahasiswa->user;

        if (!$user || !Auth::attempt(['username' => $user->username, 'password' => $request->password], $request->boolean('remember'))) {
            return back()->withErrors([
                'npm' => 'NPM atau password salah.',
            ])->withInput($request->only('npm'));
        }

        $request->session()->regenerate();

        // Ensure the user is a mahasiswa
        if (!$user->isMahasiswa()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'npm' => 'Akun ini bukan akun mahasiswa.',
            ])->withInput($request->only('npm'));
        }

        return redirect()->intended('/dashboard/mahasiswa');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
