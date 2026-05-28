<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Supplier extends Model
{
    use BelongsToUser;
    protected $fillable = ['name', 'contact_person', 'email', 'phone', 'address', 'city'];

    public function purchases() { return $this->hasMany(Purchase::class); }
}
