<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $actor;

    public function __construct(Product $product, User $actor)
    {
        $this->product = $product;
        $this->actor = $actor;
    }

    public function build()
    {
        return $this->subject('New Product Added: ' . $this->product->name)
                    ->view('Emails.product_added');
    }
}
