<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    use HasFactory;

    protected $table = 'Chatroom';
    protected $primaryKey = 'Chatroom_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'Chatroom_customer',
        'Chatroom_shop',
    ];

    public function customer() {
        return $this->belongsTo(CustomerModel::class, 'Chatroom_customer', 'id');
    }

    public function shop() {
        return $this->belongsTo(ShopModel::class, 'Chatroom_shop', 'id');
    }

    public function chats() {
        return $this->hasMany(Chat::class, 'room_id', 'Chatroom_id');
    }
}
