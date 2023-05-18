<?php

declare(strict_types =1);

namespace App\Enums;

enum ScaleFleet : string
{
    case ALL = 'ALL';
    case B717 = 'B717';
    case B727 = 'B727';
    case B737 = 'B737';
    case B738 = 'B738';
    case B739 = 'B739';
    case B747 = 'B747';
    case B757 = 'B757';
    case B753 = 'B753';
    case B767 = 'B767';
    case B763 = 'B763';
    case B764 = 'B764';
    case B777 = 'B777';
    case B787 = 'B787';
    case A220 = 'A220';
    case A300 = 'A300';
    case A319 = 'A319';
    case A320 = 'A320';
    case A321 = 'A321';
    case A332 = 'A330-200';
    case A339 = 'A330-900';
    case A340 = 'A340';
    case A350 = 'A350';
    case MD10 = 'MD-10';
    case MD11 = 'MD-11';

    public static function forSelect(): array 
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'name')
        );
    }
}