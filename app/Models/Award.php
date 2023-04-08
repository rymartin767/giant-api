<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_seniority', 'employee_number', 'domicile', 'fleet', 'seat', 'award_domicile', 'award_fleet', 'award_seat', 'is_new_hire', 'is_upgrade', 'month'
    ];

    protected $casts = [
        'is_new_hire' => 'boolean',
        'is_upgrade' => 'boolean',
        'month' => 'immutable_date:M Y'
    ];
}
