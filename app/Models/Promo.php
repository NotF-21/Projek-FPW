<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use HasFactory;

    protected $table = "promo";
    protected $primaryKey = "promo_id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "promo_name",
        "promo_amount",
        "promo_type",
        "promo_sourceshop",
        "promo_expiredate",
    ];

    public function type() {
        return $this->belongsTo(PromoType::class, 'promo_type', 'promo_type_id');
    }

    public function shop() {
        return $this->belongsTo(ShopModel::class, 'promo_sourceshop', 'id');
    }
}
