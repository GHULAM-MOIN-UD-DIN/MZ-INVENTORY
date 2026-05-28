<?php

namespace App\Mail;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $supplier;
    public $actor;

    public function __construct(Supplier $supplier, User $actor)
    {
        $this->supplier = $supplier;
        $this->actor = $actor;
    }

    public function build()
    {
        return $this->subject('New Supplier Registered: ' . $this->supplier->name)
                    ->view('Emails.supplier_added');
    }
}
