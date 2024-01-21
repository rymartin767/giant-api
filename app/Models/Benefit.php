<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'monthly_guarantee',
        'reserve_guarantee',
        'per_diem',
        'per_diem_intl',
        'domiciles',
        'has_401k',
        'has_profit_sharing',
        'notes'
    ];

    protected $casts = [
        'notes' => 'array'
    ];

    public function airline() : Relation
    {
        return $this->belongsTo(Airline::class, 'airline_id', 'id');
    }
}
