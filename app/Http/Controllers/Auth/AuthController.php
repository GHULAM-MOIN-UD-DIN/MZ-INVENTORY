<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginAlertMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Pages.Auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            try {
                Mail::to($user->email)->send(new LoginAlertMail(
                    $user,
                    $request->ip(),
                    $request->userAgent(),
                    now()->format('Y-m-d H:i:s')
                ));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Login alert email failed: ' . $e->getMessage());
            }

            return redirect()->intended('/')
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Logged out successfully.');
    }
}
