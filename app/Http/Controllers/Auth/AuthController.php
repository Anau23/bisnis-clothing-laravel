<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            session()->flash('success', 'Login berhasil!');

            return $this->redirectToDashboard();
        }

        return back()->with('danger', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah logout.');
    }

    private function redirectToDashboard()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('cashier.dashboard');
    }
}
