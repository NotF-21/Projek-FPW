<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'Review';
    protected $primaryKey = 'review_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'review_rating',
        'review_review',
        'review_shop',
        'review_customer'
    ];

    public function shop() {
        return $this->belongsTo(ShopModel::class, 'review_shop', 'id');
    }

    public function customer() {
        return $this->belongsTo(CustomerModel::class, 'review_customer', 'id');
    }
}
