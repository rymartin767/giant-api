<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    public function airline() : BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }
}
