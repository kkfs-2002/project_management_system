<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'profile_id',  // <-- this should match your foreign key
        'amount',
        'salary_month',
        'status',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
