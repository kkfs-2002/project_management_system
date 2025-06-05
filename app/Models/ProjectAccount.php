<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProjectAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'total_payment',
        'advance',
        'hosting_fee',
        'developer_fee',
    ];

    // Relationship
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Accessors for derived values
    public function getCreditAttribute()
    {
        return $this->total_payment - $this->advance;
    }

    public function getProfitAttribute()
    {
        return $this->total_payment - ($this->hosting_fee + $this->developer_fee);
    }

}
