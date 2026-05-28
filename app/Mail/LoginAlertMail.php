<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ip;
    public $userAgent;
    public $time;

    public function __construct(User $user, string $ip, string $userAgent, string $time)
    {
        $this->user = $user;
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->time = $time;
    }

    public function build()
    {
        return $this->subject('Security Alert: New Login Detected')
                    ->view('Emails.login_alert');
    }
}
