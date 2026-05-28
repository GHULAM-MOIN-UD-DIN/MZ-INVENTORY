<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('Pages.Auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'No user account found with this email address.',
        ]);

        $email = $request->email;

        // Generate a cryptographically secure 6-digit code
        $code = sprintf("%06d", random_int(0, 999999));

        // Delete any existing codes for this email and type to keep it clean
        OtpCode::where('email', $email)->where('type', 'forgot_password')->delete();

        // Create new code
        OtpCode::create([
            'email' => $email,
            'code' => $code,
            'type' => 'forgot_password',
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send Email
        try {
            Mail::to($email)->send(new SendOtpMail($code, 'forgot_password'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Forgot password OTP email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send verification code email: ' . $e->getMessage()]);
        }

        // Save email in session
        session(['forgot_password_email' => $email]);

        return redirect()->route('password.verify')
            ->with('status', 'A 6-digit verification code has been sent to your email.');
    }

    public function showVerifyForm()
    {
        if (!session()->has('forgot_password_email')) {
            return redirect()->route('password.request');
        }

        return view('Pages.Auth.forgot-password-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        if (!session()->has('forgot_password_email')) {
            return redirect()->route('password.request');
        }

        $email = session('forgot_password_email');

        $otp = OtpCode::where('email', $email)
            ->where('code', $request->code)
            ->where('type', 'forgot_password')
            ->first();

        if (!$otp || $otp->isExpired()) {
            return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
        }

        // OTP is correct! Mark as verified
        $otp->delete(); // Prevent reuse of code
        session(['forgot_password_verified' => true]);

        return redirect()->route('password.reset')
            ->with('status', 'Code verified successfully. You can now reset your password.');
    }

    public function showResetForm()
    {
        if (!session()->has('forgot_password_email') || !session('forgot_password_verified')) {
            return redirect()->route('password.request');
        }

        return view('Pages.Auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!session()->has('forgot_password_email') || !session('forgot_password_verified')) {
            return redirect()->route('password.request');
        }

        $email = session('forgot_password_email');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session keys
        session()->forget(['forgot_password_email', 'forgot_password_verified']);

        return redirect()->route('login')
            ->with('success', 'Your password has been successfully reset. Please log in.');
    }
}
