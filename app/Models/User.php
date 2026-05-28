<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'shop_name',
        'shop_logo',
        'admin_id',
    ];

    public function parentAdmin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function staffMembers()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function getShopNameAttribute($value)
    {
        if ($this->role === 'admin') {
            return $value ?? 'MZ Inventory';
        }
        return $this->parentAdmin ? ($this->parentAdmin->shop_name ?? 'MZ Inventory') : 'MZ Inventory';
    }

    public function getShopLogoAttribute($value)
    {
        if ($this->role === 'admin') {
            return $value;
        }
        return $this->parentAdmin ? $this->parentAdmin->shop_logo : null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
