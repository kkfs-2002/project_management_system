<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name',
        'nic',
        'category',
        'phone',
        'email',
        'password',
        'username',
        'profile_picture',
    ];
}
