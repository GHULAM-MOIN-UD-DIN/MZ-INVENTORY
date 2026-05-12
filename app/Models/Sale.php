<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'reference', 'customer_id', 'date', 'status', 'payment_status', 
        'grand_total', 'cash_received', 'change_return', 'service_charge', 
        'payment_method', 'discount', 'tax', 'note'
    ];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(SaleItem::class); }
}
