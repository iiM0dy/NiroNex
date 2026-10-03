<?php

namespace App\Enums;

enum IDPhotoType: int
{
    case Passport = 0;
    case IDCard = 1;
    case CivilCard = 2;

    public function label(): string
    {
        return match ($this) {
            self::Passport => 'جواز سفر',
            self::IDCard => 'الهوية الشخصية',
            self::CivilCard => 'ورقة اخراج قيد',
        };
    }
}
