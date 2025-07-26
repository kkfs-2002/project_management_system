<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedTask extends Model
{
    protected $table = 'assigned_tasks'; // <-- Custom table name

    protected $fillable = [
        'project_id',
        'developer_id',
        'project_manager_id',
        'developer_name',
        'project_manager_name',
        'title',
        'description',
        'start_date',
        'deadline',
        'status',
        'pm_forwarded_at',
        'completed_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function developer()
{
    return $this->belongsTo(\App\Models\Profile::class, 'developer_id');
}
    public function projectManager()
    {
        return $this->belongsTo(Profile::class, 'project_manager_id');
    }
}
