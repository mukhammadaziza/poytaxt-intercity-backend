<?php

namespace App\Enums;

enum CommissionType: int
{
    case Percentage = 1;
    case FixedAmount = 2;
}
