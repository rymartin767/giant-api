<?php

namespace App\Models;

use App\Enums\AirlineUnion;
use App\Enums\AirlineSector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'sector',
        'name',
        'icao',
        'iata',
        'union',
        'pilot_count',  
        'is_hiring',
        'web_url',
        'slug'
    ];

    protected $casts = [
        'sector' => AirlineSector::class,
        'union' => AirlineUnion::class,
        'is_hiring' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at', 'slug'];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->title(),
        );
    }

    protected function icao(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->upper(),
        );
    }

    protected function iata(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->upper(),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn () => str($this->name . '-' . $this->icao)->slug(),
        );
    }

    public function path($append = '') : string
    {
        $path = "/airlines/$this->icao";
        return $append ? "{$path}/{$append}" : $path;
    }

    public function scopeAtlas(Builder $query) : void
    {
        $query->where('icao', 'GTI');
    }

    public function scales() : HasMany
    {
        return $this->hasMany(Scale::class);
    }
}
