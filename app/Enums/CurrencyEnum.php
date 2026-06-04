<?php

declare(strict_types=1);

namespace App\Enums;

enum CurrencyEnum: string
{
    case EUR = 'EUR';
    case GBP = 'GBP';
    case USD = 'USD';
}
