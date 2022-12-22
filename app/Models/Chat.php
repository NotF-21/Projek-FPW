<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Chat';
    protected $primaryKey = 'chat_id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'chat_content',
        'chat_sender',
        'room_id',
    ];

    public function room() {
        return $this->belongsTo(Chatroom::class, 'room_id', 'Chatroom_id');
    }
}
