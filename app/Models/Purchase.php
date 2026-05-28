<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Purchase extends Model
{
    use BelongsToUser;

    protected $fillable = ['reference', 'supplier_id', 'date', 'status', 'payment_status', 'grand_total', 'note'];

    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function items() { return $this->hasMany(PurchaseItem::class); }
}
