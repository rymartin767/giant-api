<?php

declare(strict_types = 1);

namespace App\Enums;

enum PilotStatus : int
{
    case ACTIVE = 1;
    case LOA = 2;
    case LMED = 3;
    case MGMT = 4;
    case MIL = 5;

    public function getFullName() : string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::LOA => 'Leave of Absence',
            self::LMED => 'Long-Term Medical',
            self::MGMT => 'Management',
            self::MIL => 'Military Leave',
        };
    }
}