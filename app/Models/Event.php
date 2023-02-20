<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'date', // MYSQL YYYY-MM-DD
        'time', // MYSQL hh:mm:ss
        'location',
        'image_url',
        'web_url'
    ];

    // When defining a date or datetime cast, you may also specify the date's format. This format will be used when the model is serialized to an array or JSON:
    protected $casts = [
        'date' => 'immutable_datetime:m/d/Y',
        'time' => 'immutable_datetime:H:i'
    ];

    public function prunable()
    {
        return static::where('date', '<', now()->subDay());
    }
}
