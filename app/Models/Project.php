<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Project extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'start_date',
        'deadline',
    ];

    // One project has one account detail
    public function account()
    {
        return $this->hasOne(ProjectAccount::class);
    }

public function tasks()
{
    return $this->hasMany(\App\Models\AssignedTask::class);
}


}
