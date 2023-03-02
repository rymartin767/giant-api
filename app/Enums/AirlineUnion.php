<?php

namespace App\Enums;

enum AirlineUnion : int
{

    case IBT = 1;
    case ALPA = 2;
    case SAPA = 3;
    case NONE = 4;

    public function getFullName() : string
    {
        return match($this) {
            self::IBT => 'International Brotherhood of Teamsters',
            self::ALPA => 'Airline Pilots Association',
            self::SAPA => 'Southwest Airlines Pilot Association',
            self::NONE => 'No Union Representation'
         };
    }
}