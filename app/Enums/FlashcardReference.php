<?php

namespace App\Enums;

enum FlashcardReference : int
{
    case FCOM_VOL1_LIMITATIONS = 1;
    case FCOM_VOL1_NORMAL_PROCEDURES = 2;
    case FCOM_VOL1_SUPPLEMENTARY_PROCEDURES = 3;

    public function getFullName() : string
    {
        return match($this) {
            self::FCOM_VOL1_LIMITATIONS => 'FCOM VOL1: Limitations',
            self::FCOM_VOL1_NORMAL_PROCEDURES => 'FCOM VOL1: Normal Procedures',
            self::FCOM_VOL1_SUPPLEMENTARY_PROCEDURES => 'FCOM VOL1: Supplementary Procedures',
        };
    }
}