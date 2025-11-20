<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    protected $fillable = [
        'profile_id', 'task_date', 'task_name', 'description', 'task_type',
        'target_count', 'start_time', 'end_time', 'working_days', // Add working_days here
        'completed_count', 'estimated_time', 'actual_time',
        'priority', 'status', 'notes', 'assigned_by', 'completed_at'
    ];

    protected $casts = [
        'task_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'estimated_time' => 'datetime:H:i',
        'actual_time' => 'datetime:H:i',
        'completed_at' => 'datetime'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Profile::class, 'assigned_by');
    }

    // Calculate completion percentage
    public function getCompletionPercentageAttribute()
    {
        if ($this->target_count > 0) {
            return ($this->completed_count / $this->target_count) * 100;
        }
        return 0;
    }

    // Check if task is completed
    public function getIsCompletedAttribute()
    {
        return $this->completed_count >= $this->target_count;
    }

    // Get working days as array
    public function getWorkingDaysArrayAttribute()
    {
        return $this->working_days ? explode(',', $this->working_days) : [];
    }
}