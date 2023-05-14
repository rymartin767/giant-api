<?php

namespace App\Models;

use App\Enums\ScaleFleet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scale extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'fleet',
        'ca_rate',
        'fo_rate'
    ];

    protected $casts = [
        'fleet' => ScaleFleet::class
    ];

    public function airline() : BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }
}
