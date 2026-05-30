<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class ProductType extends Model
{
    use BelongsToUser;
    protected $fillable = ['name'];
}
