<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class SaleItem extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'unit_price', 'subtotal'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
