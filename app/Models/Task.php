<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'developer_id',
        'project_manager_id',
        'developer_name',
        'project_manager_name',
        'title',
        'description',
        'deadline',
        'status',
        'pm_forwarded_at',
        'completed_at',
    ];
}
