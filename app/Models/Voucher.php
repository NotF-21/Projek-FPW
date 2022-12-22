<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = "voucher";
    protected $primaryKey = "voucher_id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "voucher_name",
        "voucher_amount",
        "voucher_type",
        "voucher_sourceadmin",
        "voucher_expiredate",
    ];

    public function type() {
        return $this->belongsTo(PromoType::class, 'voucher_type', 'promo_type_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'voucher_sourceadmin', 'id');
    }
}
