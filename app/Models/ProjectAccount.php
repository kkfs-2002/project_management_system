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
        'profit',
        'balance',
        'renewal_date',
    ];

    protected $casts = [
        'renewal_date' => 'date',
    ];

    // Relationship
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Accessors for derived values (optional - ඔබට ඕන නම්)
    public function getCreditAttribute()
    {
        return $this->total_payment - $this->advance;
    }

    // Auto calculate profit if not set
    public function getProfitAttribute($value)
    {
        if ($value === null) {
            return $this->total_payment - ($this->hosting_fee + $this->developer_fee);
        }
        return $value;
    }

    // Auto calculate balance if not set
    public function getBalanceAttribute($value)
    {
        if ($value === null) {
            return $this->total_payment - $this->advance;
        }
        return $value;
    }
}