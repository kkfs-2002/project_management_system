<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'phone_number',
        'date',
        'project_type',
        'project_category',
        'project_price',
        'contact_method',
        'call_sequence',
        'first_call_date',
        'second_call_date',
        'third_call_date',
          'reminder_date',
        'comments',
        'marketing_manager_id',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'first_call_date' => 'date',
        'second_call_date' => 'date',
        'third_call_date' => 'date',
        'reminder_date' => 'date',
        'project_price' => 'decimal:2',
    ];

    // Relationship with Marketing Manager
    public function marketingManager()
    {
        return $this->belongsTo(Profile::class, 'marketing_manager_id', 'employee_id');
    }
}