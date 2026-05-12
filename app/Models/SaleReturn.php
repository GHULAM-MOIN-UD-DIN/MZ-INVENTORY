<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $table = 'returns';
    protected $fillable = ['reference', 'customer_id', 'supplier_id', 'date', 'type', 'grand_total', 'note'];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
}
