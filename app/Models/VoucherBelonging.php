<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherBelonging extends Model
{
    use HasFactory;

    protected $table = "voucher_customer";
    protected $primaryKey = "voucher_customer_id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "voucher_customer_customer",
        "voucher_customer_voucher",
    ];

    public function voucher() {
        return $this->belongsTo(Voucher::class, 'voucher_customer_voucher', 'voucher_id');
    }

    public function customer() {
        return $this->belongsTo(CustomerModel::class, 'voucher_customer_customer', 'id');
    }
}
