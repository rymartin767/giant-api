<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staffing extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_date',
        'total_pilot_count',
        'active_pilot_count',
        'inactive_pilot_count',
        'net_gain_loss',
        'ytd_gain_loss',
        'average_age',
    ];

    protected $casts = [
        'list_date' => 'immutable_date:m/d/Y'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
