<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'Shop';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'shop_username',
        'shop_password',
        'shop_name',
        'shop_emailaddress',
        'shop_phonenumber',
        'shop_accountnumber',
        'shop_address',
    ];

    protected $guarded = [];

    public function getAuthPassword()
    {
        return $this->shop_password;
    }

    public function sells(){
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }

    public function promos() {
        return $this->hasMany(Promo::class, 'promo_sourceshop', 'id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'review_shop', 'id');
    }
}
