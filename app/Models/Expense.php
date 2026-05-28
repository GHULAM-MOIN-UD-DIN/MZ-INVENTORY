<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Expense extends Model
{
    use HasFactory, BelongsToUser;

    protected $fillable = ['date', 'reference', 'category', 'amount', 'note'];
}
