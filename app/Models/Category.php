<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Category extends Model
{
    use BelongsToUser;
    protected $fillable = ['name', 'image'];

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
