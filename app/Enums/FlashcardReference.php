<?php

namespace App\Enums;

enum FlashcardReference : int
{
    case FCOM_VOL1_LIMITATIONS = 1;
    case FCOM_VOL1_NORMAL_PROCEDURES = 2;
    case FCOM_VOL1_SUPPLEMENTARY_PROCEDURES = 3;
    case FCOM_VOL1_SMAC = 4;
    case FCOM_VOL2__CHAPTER_1_GENERAL = 5;
    case FCOM_VOL2__CHAPTER_2_AIR_SYSTEMS = 6;
    case FCOM_VOL2__CHAPTER_3_ANTI_ICE_RAIN = 7;
    case FCOM_VOL2__CHAPTER_4_AUTOMATIC_FLIGHT = 8;
    case FCOM_VOL2__CHAPTER_5_COMMUNICATIONS = 9;
    case FCOM_VOL2__CHAPTER_6_ELECTRICAL = 10;
    case FCOM_VOL2__CHAPTER_7_ENGINES = 11;
    case FCOM_VOL2__CHAPTER_8_FIRE_PROTECTION = 12;
    case FCOM_VOL2__CHAPTER_9_FLIGHT_CONTROLS = 13;
    case FCOM_VOL2__CHAPTER_10_FLIGHT_INSTRUMENTS_DISPLAYS = 14;

    public function getFullName() : string
    {
        return match($this) {
            self::FCOM_VOL1_LIMITATIONS => 'FCOM VOL1: Limitations',
            self::FCOM_VOL1_NORMAL_PROCEDURES => 'FCOM VOL1: Normal Procedures',
            self::FCOM_VOL1_SUPPLEMENTARY_PROCEDURES => 'FCOM VOL1: Supplementary Procedures',
            self::FCOM_VOL1_SMAC => 'FCOM VOL1: Standard Maneuvers & Configurations',
            self::FCOM_VOL2__CHAPTER_1_GENERAL => 'FCOM VOL2: Chapter 1 - Airplane General, Emergency Equipment, Doors, & Windows',
            self::FCOM_VOL2__CHAPTER_2_AIR_SYSTEMS => 'FCOM VOL2: Chapter 2 - Air Systems',
            self::FCOM_VOL2__CHAPTER_3_ANTI_ICE_RAIN => 'FCOM VOL2: Chapter 3 - Anti-Ice & Rain',
            self::FCOM_VOL2__CHAPTER_4_AUTOMATIC_FLIGHT => 'FCOM VOL2: Chapter 4 - Automatic Flight',
            self::FCOM_VOL2__CHAPTER_5_COMMUNICATIONS => 'FCOM VOL2: Chapter 5 - Communications',
            self::FCOM_VOL2__CHAPTER_6_ELECTRICAL => 'FCOM VOL2: Chapter 6 - Electrical',
            self::FCOM_VOL2__CHAPTER_7_ENGINES => 'FCOM VOL2: Chapter 7 - Engines',
            self::FCOM_VOL2__CHAPTER_8_FIRE_PROTECTION => 'FCOM VOL2: Chapter 8 - Fire Protection',
            self::FCOM_VOL2__CHAPTER_9_FLIGHT_CONTROLS => 'FCOM VOL2: Chapter 9 - Flight Controls',
            self::FCOM_VOL2__CHAPTER_10_FLIGHT_INSTRUMENTS_DISPLAYS => 'FCOM VOL2: Chapter 10 - Flight Instruments & Displays',
        };
    }
}