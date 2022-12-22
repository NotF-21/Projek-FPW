<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoType extends Model
{
    use HasFactory;

    protected $table = "promo_type";
    protected $primaryKey = "promo_type_id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'promo_type_name'
    ];

    public function hasPromo() {
        return $this->hasMany(Promo::class, 'promo_type', 'promo_type_id');
    }

    public function hasPromoGlobal() {
        return $this->hasMany(PromoGlobal::class, 'promo_global_type', 'promo_type_id');
    }

    public function hasVoucher() {
        return $this->hasMany(Voucher::class, 'voucher_type', 'promo_type_id');
    }
}
