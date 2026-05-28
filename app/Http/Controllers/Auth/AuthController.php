<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use App\Mail\SendOtpMail;
use App\Mail\LoginAlertMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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

        // Check if user exists and password is correct
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Generate a 6-digit OTP code
            $code = sprintf("%06d", random_int(0, 999999));

            // Clean up any old login OTP codes for this user
            OtpCode::where('email', $user->email)->where('type', 'login_2fa')->delete();

            // Create new OTP code
            OtpCode::create([
                'email' => $user->email,
                'code' => $code,
                'type' => 'login_2fa',
                'expires_at' => now()->addMinutes(10),
            ]);

            // Send SMTP Email
            try {
                Mail::to($user->email)->send(new SendOtpMail($code, 'login_2fa'));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Login 2FA OTP email failed: ' . $e->getMessage());
                return back()->withErrors([
                    'email' => 'Failed to send verification code: ' . $e->getMessage(),
                ]);
            }

            // Save login credentials/preferences temporarily in session
            session([
                'login_2fa_email' => $user->email,
                'login_2fa_remember' => $remember,
            ]);

            return redirect()->route('login.verify')
                ->with('status', 'A 6-digit verification code has been sent to your email.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showVerify2Fa()
    {
        if (!session()->has('login_2fa_email')) {
            return redirect()->route('login');
        }

        return view('Pages.Auth.login-verify');
    }

    public function verify2Fa(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        if (!session()->has('login_2fa_email')) {
            return redirect()->route('login');
        }

        $email = session('login_2fa_email');
        $remember = session('login_2fa_remember', false);

        $otp = OtpCode::where('email', $email)
            ->where('code', $request->code)
            ->where('type', 'login_2fa')
            ->first();

        if (!$otp || $otp->isExpired()) {
            return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
        }

        // OTP is correct! Delete OTP code
        $otp->delete();

        // Authenticate User
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'User not found.']);
        }

        Auth::login($user, $remember);
        $request->session()->regenerate();

        // Clear 2FA session data
        session()->forget(['login_2fa_email', 'login_2fa_remember']);

        // Send login alert email
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
            ->with('success', 'Welcome back, ' . $user->name . '!');
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

