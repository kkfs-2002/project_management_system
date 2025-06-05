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
    ];

    // One project has one account detail
    public function account()
    {
        return $this->hasOne(ProjectAccount::class);
    }

}
