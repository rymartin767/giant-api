<?php

namespace App\Enums;

enum FlashcardCategory : int
{
    // VOL 1
    case LIMITATIONS = 1;
    case AIRCRAFT_GENERAL = 2;

    // VOL 1 NORMAL PROCEDURES
    case NP_15_PREFLIGHT = 30;
    case NP_20_BEFORE_START = 31;
    case NP_21_BEFORE_TAXI = 32;
    case NP_25_TAXI_OUT = 33;
    case NP_30_BEFORE_TAKEOFF_PROCEDURE = 34;
    case NP_35_TAKEOFF_PROCEDURE = 35;
    case NP_40_CLIMB_AND_CRUISE = 36;
    case NP_45_DESCENT = 37;
    case NP_50_APPROACH = 38;
    case NP_55_GO_AROUND = 39;
    case NP_60_LANDING = 40;
    case NP_65_AFTER_LANDING_PROCEDURE = 41;
    case NP_70_SHUTDOWN_PROCEDURE = 42;
    case NP_75_POSTFLIGHT_PROCEDURE = 43;
    case NP_80_SECURING = 44;

    // VOL 1 SMAC
    case SMAC_80_HOLDING = 22;
    case SMAC_93_NON_ILS_APPROACH = 21;
    case SMAC_100_GO_AROUND = 25;

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

            self::NP_15_PREFLIGHT => 'NP 15: Preflight',
            self::NP_20_BEFORE_START => 'NP 20: Before Start',
            self::NP_21_BEFORE_TAXI => 'NP 21: Before Taxi',
            self::NP_25_TAXI_OUT => 'NP 25: Taxi-Out',
            self::NP_30_BEFORE_TAKEOFF_PROCEDURE => 'NP 30: Before Takeoff Procedure',
            self::NP_35_TAKEOFF_PROCEDURE => 'NP 35: Takeoff Procedure',
            self::NP_40_CLIMB_AND_CRUISE => 'NP 40: Climb & Cruise',
            self::NP_45_DESCENT => 'NP 45: Descent',
            self::NP_50_APPROACH => 'NP 50: Approach',
            self::NP_55_GO_AROUND => 'NP 55: Go-Around',
            self::NP_60_LANDING => 'NP 60: Landing',
            self::NP_65_AFTER_LANDING_PROCEDURE => 'NP 65: After Landing Procedure',
            self::NP_70_SHUTDOWN_PROCEDURE => 'NP 70: Shutdown Procedure',
            self::NP_75_POSTFLIGHT_PROCEDURE => 'NP 75: Postflight Procedure',
            self::NP_80_SECURING => 'NP 80: Securing',

            self::SMAC_80_HOLDING => 'SMAC 80: Holding',
            self::SMAC_93_NON_ILS_APPROACH => 'SMAC 93: Non-ILS Approach',
            self::SMAC_100_GO_AROUND => 'SMAC 100: Go-Around'
        };
    }
}