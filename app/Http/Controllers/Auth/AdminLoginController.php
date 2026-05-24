<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the admin/staff login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() && !Auth::user()->isMahasiswa()) {
            return redirect(Auth::user()->getDashboardRoute());
        }

        return view('auth.admin-login');
    }

    /**
     * Handle admin/staff login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Ensure the user is not a mahasiswa
            if ($user->isMahasiswa()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'username' => 'Akun mahasiswa tidak dapat login di sini. Gunakan halaman login mahasiswa.',
                ])->withInput($request->only('username'));
            }

            return redirect()->intended($user->getDashboardRoute());
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/masuk/admin');
    }
}
