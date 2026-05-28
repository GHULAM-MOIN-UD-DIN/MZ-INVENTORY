<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;
    public $type;
    public $expiresInMinutes;

    public function __construct(string $otpCode, string $type, int $expiresInMinutes = 15)
    {
        $this->otpCode = $otpCode;
        $this->type = $type;
        $this->expiresInMinutes = $expiresInMinutes;
    }

    public function build()
    {
        $subject = $this->type === 'forgot_password' 
            ? 'Reset Password Verification Code' 
            : '2-Step Login Verification Code';

        return $this->subject($subject)
                    ->view('Emails.send_otp');
    }
}
