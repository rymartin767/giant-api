<?php

namespace App\Actions\Scales;

use App\Models\Scale;

final class CreateScale
{
    public function __construct(public Array $validated) {}
    
    public function handle() : Scale
    {
        return Scale::create($this->validated);
    }
}