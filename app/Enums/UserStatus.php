<?php

namespace App\Enums;

enum UserStatus: int
{
    case Active = 1;
    case Deactivated = 2;
    case Blocked = 3;
    case Archived = 4;
}
