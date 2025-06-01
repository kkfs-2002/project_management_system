<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'client_name',
        'contact_number',
        'project_name',
        'project_type',
        'technology',
        'reminder_date',
        'note',
        'cost',
        'status',
    ];

}
