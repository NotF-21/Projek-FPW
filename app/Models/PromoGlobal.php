<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoGlobal extends Model
{
    use HasFactory;

    protected $table = "promo_global";
    protected $primaryKey = "promo_global_id";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        "promo_global_name",
        "promo_global_amount",
        "promo_global_type",
        "promo_global_sourceadmin",
        "promo_global_expiredate",
    ];

    public function type() {
        return $this->belongsTo(PromoType::class, 'promo_global_type', 'promo_type_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'promo_global_sourceadmin', 'id');
    }
}
