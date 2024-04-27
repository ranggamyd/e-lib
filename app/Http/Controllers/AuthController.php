<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index', [
            'title' => 'Masuk ke Dashboard',
            'bodyClass' => 'hold-transition login-page'
        ]);
    }

    public function login_process(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('members')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('failed', 'User tidak ditemukan');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
