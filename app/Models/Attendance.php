<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'user_id',       // Keep for legacy, but nullable
        'user_type',
        'profile_id',    // Primary FK now
        'role',
        'date',
        'check_in',
        'check_out',
        'total_hours',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'date' => 'date',
        'total_hours' => 'decimal:2',
    ];

    // Relationships
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function user()  // Legacy, if needed
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}