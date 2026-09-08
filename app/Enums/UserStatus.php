<?php

namespace App\Enums;

enum UserStatus: int
{
    case Active = 1;
    case Blocked = 2;
    case NonActive = 3;
    case Archived = 4;
}
