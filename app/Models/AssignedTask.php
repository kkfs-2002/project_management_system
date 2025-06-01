<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedTask extends Model
{
    protected $fillable = [
        'developer_id',
        'project_manager_id',
        'date',
        'task_description',
        'project_name',
        'deadline',
        'priority',
        'status',
    ];
}
