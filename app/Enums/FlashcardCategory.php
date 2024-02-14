<?php

namespace App\Enums;

enum FlashcardCategory : int
{
    // VOL 1
    case LIMITATIONS = 1;
    case AIRCRAFT_GENERAL = 2;

    // VOL 2
    case AIR_SYSTEMS = 3;
    case ANTI_ICE = 4;
    case AUTOMATIC_FLIGHT = 5;
    case ELECTRICAL = 6;
    case ENGINES_APU = 7;
    case FIRE_PROTECTION = 8;
    case FLIGHT_INSTRUMENTS = 9;
    case FLIGHT_MANAGEMENT = 10;
    case FLIGHT_CONTROLS_HYDRAULICS = 11;
    case FUEL = 12;
    case WARNING_SYSTEMS = 13;

    // FOM
    case FOM = 14;

    // SMAC
    case SMAC_93_NON_ILS_APPROACH = 21;

    public function getLabel() : string
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
            self::FLIGHT_CONTROLS_HYDRAULICS => 'Flight Controls & Hydraulics',
            self::FUEL => 'Fuel',
            self::WARNING_SYSTEMS => 'Warning Systems',
            self::FOM => 'Flight Operations Manual',
            self::SMAC_93_NON_ILS_APPROACH => 'SMAC 93: Non-ILS Approach'
        };
    }
}