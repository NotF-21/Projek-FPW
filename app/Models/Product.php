<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Product';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'product_name',
        'product_price',
        'product_desc',
        'product_stock',
        'type_id',
        'shop_id'
    ];

    public function type() {
        return $this->belongsTo(ProductType::class, 'type_id', 'id');
    }

    public function shop() {
        return $this->belongsTo(ShopModel::class, 'shop_id', 'id');
    }

    public function favorite() {
        return $this->belongsToMany(CustomerModel::class, 'favorit', 'favorite_product', 'favorite_customer');
    }

    public function cart() {
        return $this->belongsToMany(CustomerModel::class, 'cart', 'product_id', 'customer_id')->withPivot(["amount"]);
    }
}
