<?php

namespace App\Enums;

enum FlashcardEicasType : int
{
    case WARNING = 1;
    case CAUTION = 2;
    case ADVISORY = 3;
    case STATUS = 4;
    case COMMUNICATION = 5;
}