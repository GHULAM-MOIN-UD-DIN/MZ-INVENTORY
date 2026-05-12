<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'type',
        'name',
        'code',
        'barcode_symbology',
        'category_id',
        'cost',
        'price',
        'tax_method',
        'quantity',
        'image',
        'description'
    ];

    // Relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
