<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'contact_number',
        'project_name',
        'project_type',
        'technology',
        'reminder_date',
        'note',
        'amount',
        'payment_status',
        'status',
        'edit_permission',
        'marketing_manager_id',
         'cancel_reason'
    ];
    

}
