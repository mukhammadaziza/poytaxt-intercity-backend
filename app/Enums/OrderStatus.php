<?php

namespace App\Enums;

enum OrderStatus: int
{
    case Starter = 1;
    case Open = 2;
    case AttachedToDriver = 3;
    case HasTaken = 4;
    case Finished = 5;
    case Cancelled = 6;
}
