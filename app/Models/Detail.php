<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'D_Trans';
    protected $primaryKey = 'dtrans_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'invoice_number',
        'product_id',
        'product_number',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'invoice_number', 'invoice_number');
    }
}
