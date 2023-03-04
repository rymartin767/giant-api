<?php

namespace App\Enums;

enum FlashcardCategory : int
{
    case LIMITATIONS = 1;
    case AIRCRAFT_GENERAL = 2;
    case AIR_SYSTEMS = 3;
    case ANTI_ICE = 4;
    case AUTOMATIC_FLIGHT = 5;
    case ELECTRICAL = 6;
    case ENGINES_APU = 7;
    case FIRE_PROTECTION = 8;
    case FLIGHT_INSTRUMENTS = 9;
    case FLIGHT_MANAGEMENT = 10;
    case FUEL = 11;
    case WARNING_SYSTEMS = 12;

    public function getFullName() : string
    {
        return match($this) {
            self::LIMITATIONS => 'Limitations',
            self::AIRCRAFT_GENERAL => 'Airplane General',
            self::AIR_SYSTEMS => 'Air Systems',
            self::ANTI_ICE => 'Anti-Ice & Rain',
            self::AUTOMATIC_FLIGHT => 'Automatic Flight',
            self::ELECTRICAL => 'Electrical',
            self::ENGINES_APU => 'Engines & APU',
            self::FIRE_PROTECTION => 'Fire Protection',
            self::FLIGHT_INSTRUMENTS => 'Flight Instruments',
            self::FLIGHT_MANAGEMENT => 'Flight Management & Navigation',
            self::FUEL => 'Fuel',
            self::WARNING_SYSTEMS => 'Warning Systems'
        };
    }
}