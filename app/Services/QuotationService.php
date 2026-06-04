<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\QuotationData;
use App\Enums\AgeLoadEnum;
use App\Models\Quotation;
use App\Models\User;

final class QuotationService
{
    private const int FIXED_RATE = 3;

    public function createForUser(QuotationData $data, User $user): Quotation
    {
        $tripLength = (int) ($data->start_date->diffInDays($data->end_date) + 1);

        /** @var array<int, int> $ages */
        $ages = $data->age;

        $total = array_sum(array_map(
            fn (int $age): float => self::FIXED_RATE * AgeLoadEnum::loadForAge($age) * $tripLength,
            $ages,
        ));

        /** @var Quotation $quotation */
        $quotation = $user->quotations()->create([
            'ages'        => $data->age,
            'currency_id' => $data->currency_id,
            'start_date'  => $data->start_date,
            'end_date'    => $data->end_date,
            'trip_length' => $tripLength,
            'total'       => round($total, 2),
        ]);

        return $quotation;
    }
}
