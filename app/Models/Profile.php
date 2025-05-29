<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
    'full_name', 'employee_id', 'nic', 'dob', 'gender', 'profile_photo',
    'phone', 'email', 'address', 'emergency_contact_name', 'emergency_contact_phone',
    'department', 'job_title', 'employment_type', 'date_of_joining', 'employee_status',
    'supervisor', 'work_location', 'username', 'role', 'password',
    'basic_salary', 'bank_account_number', 'bank_name', 'epf_etf_number', 'tax_code',
    'resume', 'offer_letter', 'id_copy', 'signed_contract', 'certificates'
    ];

}
