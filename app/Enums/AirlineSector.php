<?php

namespace App\Enums;

enum AirlineSector : int
{
    case CARGO = 1;
    case LEGACY = 2;
    case MAJOR = 3;
    case REGIONAL = 4;
    case CORPORATE = 5;

    public function getLabel() : string
    {
        return match($this) {
            self::CARGO => 'Cargo',
            self::LEGACY => 'Legacy',
            self::MAJOR => 'Major',
            self::REGIONAL => 'Regional',
            self::CORPORATE => 'Corporate',
        };
    }
}