<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Profile extends Authenticatable
{
    use Notifiable;

    protected $table = 'profiles';
   
    protected $fillable = [
        'full_name', 'employee_id', 'nic', 'dob', 'gender', 'profile_photo',
        'phone', 'email', 'address', 'emergency_contact_name', 'emergency_contact_phone',
        'department', 'job_title', 'employment_type', 'date_of_joining', 'employee_status',
        'supervisor', 'work_location', 'username', 'role', 'password',
        'basic_salary', 'bank_account_number', 'bank_name', 'epf_etf_number', 'tax_code',
        'resume', 'offer_letter', 'id_copy', 'signed_contract', 'certificates',
        'employee_type', 'user_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
       
    ];
   
    /**
     * Relationship to User (if User model exists; otherwise, comment out)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'profile_id');
    }

    /**
     * Relationship to Daily Tasks
     */
    public function dailyTasks()
    {
        return $this->hasMany(DailyTask::class, 'profile_id');
    }

    /**
     * Get today's attendance
     */
    public function getTodayAttendance()
    {
        return $this->attendances()
            ->whereDate('date', Carbon::today())
            ->first();
    }

    /**
     * Check if checked in today
     */
    public function hasCheckedInToday()
    {
        $attendance = $this->getTodayAttendance();
        return $attendance && $attendance->check_in;
    }

    /**
     * Check if checked out today
     */
    public function hasCheckedOutToday()
    {
        $attendance = $this->getTodayAttendance();
        return $attendance && $attendance->check_out;
    }

    /**
     * Get attendance status for today
     */
    public function getTodayAttendanceStatus()
    {
        $attendance = $this->getTodayAttendance();
        
        if (!$attendance || !$attendance->check_in) {
            return 'not_checked_in';
        }
        
        if ($attendance->check_in && !$attendance->check_out) {
            return 'checked_in';
        }
        
        if ($attendance->check_in && $attendance->check_out) {
            return 'completed';
        }
        
        return 'unknown';
    }

    /**
     * Get full display name with employee ID
     */
    public function getFullDisplayNameAttribute()
    {
        return $this->full_name . ' (' . $this->employee_id . ')';
    }

    /**
     * Check if profile is active
     */
    public function isActive()
    {
        return $this->employee_status === 'active';
    }
}