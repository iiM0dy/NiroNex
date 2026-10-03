<?php

namespace App\Enums;

enum UserStatus: int
{
    case Pending = 0;
    case Active = 1;
    case Inactive = 2;
}
