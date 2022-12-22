<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = "Admin";

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "admin_username",
        "admin_password",
    ];

    protected $guarded = [];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }
}
