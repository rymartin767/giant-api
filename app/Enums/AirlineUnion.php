<?php

namespace App\Enums;

enum AirlineUnion : int
{

    case IBT = 1;
    case ALPA = 2;
    case SAPA = 3;
    case NONE = 4;

    public function getLabel() : string
    {
        return match($this) {
            self::IBT => 'IBT',
            self::ALPA => 'APA',
            self::SAPA => 'SAPA',
            self::NONE => 'None'
         };
    }
}