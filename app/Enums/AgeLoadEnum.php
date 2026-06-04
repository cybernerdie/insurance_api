<?php

declare(strict_types=1);

namespace App\Enums;

enum AgeLoadEnum
{
    case YOUNG_ADULT;
    case ADULT;
    case MIDDLE_AGED;
    case SENIOR;
    case ELDER;

    public function load(): float
    {
        return match ($this) {
            self::YOUNG_ADULT => 0.6,
            self::ADULT       => 0.7,
            self::MIDDLE_AGED => 0.8,
            self::SENIOR      => 0.9,
            self::ELDER       => 1.0,
        };
    }

    public static function fromAge(int $age): self
    {
        return match (true) {
            $age <= 30 => self::YOUNG_ADULT,
            $age <= 40 => self::ADULT,
            $age <= 50 => self::MIDDLE_AGED,
            $age <= 60 => self::SENIOR,
            default    => self::ELDER,
        };
    }

    public static function loadForAge(int $age): float
    {
        return self::fromAge($age)->load();
    }
}
