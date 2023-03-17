<?php

namespace App\Enums;

enum ArticleCategory : int
{
    case GENERAL = 1;
    case HIRING = 2;

    public function getFullName() : string{
        return match($this) {
            self::GENERAL => 'General',
            self::HIRING => 'Hiring'
        };
    }
}