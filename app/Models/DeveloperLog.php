<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeveloperLog extends Model
{
    protected $fillable = [
        'project_manager_id',
        'developer_id',
        'date',
        'project_name',
        'task_summary',
        'time_spent',
        'task_status',
        'remarks',
    ];
}
