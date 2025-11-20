<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeKpi extends Model
{
    protected $fillable = [
        'profile_id', 'kpi_name', 'description', 'measurement_unit',
        'daily_target', 'weekly_target', 'monthly_target', 'current_achievement',
        'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // Calculate achievement percentage
    public function getAchievementPercentageAttribute()
    {
        if ($this->daily_target > 0) {
            return ($this->current_achievement / $this->daily_target) * 100;
        }
        return 0;
    }

    // Check if KPI is achieved
    public function getIsAchievedAttribute()
    {
        return $this->current_achievement >= $this->daily_target;
    }
}