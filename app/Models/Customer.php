<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'city'];

    public function sales() { return $this->hasMany(Sale::class); }
    public function returns() { return $this->hasMany(SaleReturn::class); }
}
