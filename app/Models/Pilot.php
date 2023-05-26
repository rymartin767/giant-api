<?php

namespace App\Models;

use App\Enums\PilotStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pilot extends Model
{
    use HasFactory;

    protected $fillable = [
        'seniority_number', 'employee_number', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'status', 'month'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'doh' => 'immutable_date:m/d/Y',
        'retire' => 'immutable_date:m/d/Y',
        'active' => 'boolean',
        'status' => PilotStatus::class,
        'month' => 'immutable_date:M Y'
    ];

    public function scopeCurrentSeniorityList($query)
    {
        $month = Pilot::latest()->first()->month;
        return $query->where('month', $month);
    }

    public function award()
    {
        return $this->hasOne(Award::class, 'employee_number', 'employee_number');
    }
}
