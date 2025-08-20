<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeknisiOwnerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.teknisi-owner-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role === 'owner' || Auth::user()->role === 'teknisi') {
                return redirect('/beranda');
            }
            Auth::logout();
            return back()->withErrors(['email' => 'Anda tidak memiliki akses.']);
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}