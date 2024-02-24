<?php

namespace App\Models;

use Carbon\Carbon;
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
        $month = Pilot::latest('month')->first()?->month;
        $query->where('month', Carbon::parse($month)->format('Y-m-d'));
    }

    public function scopeJuniorCaptainByFleet($query, $fleet, $month)
    {
        return $query->where('seat', 'CA')->where('fleet', $fleet)->where('month', $month)->orderBy('seniority_number')->get()->last();
    }

    public function award()
    {
        return $this->hasOne(Award::class, 'employee_number', 'employee_number');
    }
}
