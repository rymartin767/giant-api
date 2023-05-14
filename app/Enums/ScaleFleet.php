<?php

declare(strict_types =1);

namespace App\Enums;

enum ScaleFleet : int
{
    case ALL = 999;
    case B717 = 717;
    case B727 = 727;
    case B737 = 737;
    case B738 = 738;
    case B739 = 739;
    case B747 = 747;
    case B757 = 757;
    case B753 = 753;
    case B767 = 767;
    case B763 = 763;
    case B764 = 764;
    case B777 = 777;
    case B787 = 787;
    case A220 = 220;
    case A300 = 300;
    case A319 = 319;
    case A320 = 320;
    case A321 = 321;
    case A332 = 332;
    case A339 = 339;
    case A340 = 340;
    case A350 = 350;
    case MD10 = 10;
    case MD11 = 11;

    public function getFullName() : string
    {
        return match ($this) {
            self::ALL => 'ALL FLEETS',
            self::B717 => 'B717',
            self::B727 => 'B727',
            self::B737 => 'B737',
            self::B738 => 'B737-800',
            self::B739 => 'B737-900',
            self::B747 => 'B747',
            self::B757 => 'B757',
            self::B753 => 'B757-300',
            self::B767 => 'B767',
            self::B763 => 'B767-300',
            self::B764 => 'B767-400',
            self::B777 => 'B777',
            self::B787 => 'B787',
            self::A220 => 'A220',
            self::A300 => 'A300',
            self::A319 => 'A319',
            self::A320 => 'A320',
            self::A321 => 'A321',
            self::A332 => 'A330-200',
            self::A339 => 'A330-900',
            self::A340 => 'A340',
            self::A350 => 'A350',
            self::MD10 => 'MD-10',
            self::MD11 => 'MD-11',
        };
    }
}