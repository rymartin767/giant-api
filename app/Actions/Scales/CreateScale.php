<?php

namespace App\Actions\Scales;

use App\Models\Scale;
use App\Models\Airline;

final class CreateScale
{
    public function __construct(private Airline $airline, private Array $validated) {}
    
    public function handle() : Scale
    {
        return $this->airline->scales()->create($this->validated);
    }
}