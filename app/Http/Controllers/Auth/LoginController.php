<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user->approved_by_admin && !$user->isAdmin()) {
                Auth::logout();
                return back()
                    ->withErrors(['email' => 'Akun Anda belum disetujui oleh admin.'])
                    ->withInput();
            }

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::redirectBasedOnRole($user));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
