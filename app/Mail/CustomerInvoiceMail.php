<?php

namespace App\Mail;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $shopName;
    public $adminEmail;

    public function __construct(Sale $sale, string $shopName, string $adminEmail)
    {
        $this->sale = $sale;
        $this->shopName = $shopName;
        $this->adminEmail = $adminEmail;
    }

    public function build()
    {
        return $this->subject('Invoice #' . str_pad($this->sale->id, 5, '0', STR_PAD_LEFT) . ' from ' . $this->shopName)
                    ->view('Emails.customer_invoice');
    }
}
