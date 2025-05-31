<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'date',
        'check_in',
        'check_out',
        'total_hours',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
        'total_hours' => 'float',
    ];

    // Relationship to employee profile
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
