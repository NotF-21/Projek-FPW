<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'Customer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_username',
        'customer_password',
        'customer_name',
        'customer_address',
        'customer_phonenumber',
        'customer_gender',
        'customer_accountnumber'
    ];

    protected $guarded = [];

    public function getAuthPassword()
    {
        return $this->customer_password;
    }

    public function favorite() {
        return $this->belongsToMany(Product::class, 'favorit', 'favorite_customer', 'favorite_product');
    }

    public function cart() {
        return $this->belongsToMany(Product::class, 'cart', 'customer_id', 'product_id')->withPivot(["amount"]);
    }

    public function trans() {
        return $this->hasMany(Transaction::class, 'trans_customer', 'id');
    }
}
