<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class BarcodeSymbology extends Model
{
    use BelongsToUser;
    protected $fillable = ['name', 'format_type'];
}
