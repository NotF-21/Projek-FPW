<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'H_Trans';
    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'invoice_number',
        'trans_date',
        'trans_total',
        'trans_customer',
        'trans_token',
        'payment_status',
        'order_status',
        'shipping_address'
    ];

    public function customer() {
        return $this->belongsTo(CustomerModel::class, 'trans_customer', 'id');
    }

    public function details() {
        return $this->hasMany(Detail::class, 'invoice_number', 'invoice_number');
    }
}
