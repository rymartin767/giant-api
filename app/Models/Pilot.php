<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    use HasFactory;

    protected $fillable = [
        'seniority_number', 'employee_number', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'active', 'month'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'doh' => 'immutable_date:m/d/Y',
        'retire' => 'immutable_date:m/d/Y',
        'active' => 'boolean',
        'month' => 'immutable_date:M Y'
    ];

    public function scopeCurrentSeniorityList($query)
    {
        return $query->where('month', Pilot::pluck('month')->unique()->sort()->last());
    }

    public function award()
    {
        return $this->hasOne(Award::class, 'employee_number', 'employee_number');
    }
}
