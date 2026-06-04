<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\CurrencyEnum;
use Carbon\CarbonImmutable;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class QuotationData extends Data
{
    /**
     * @param array<int, int> $age
     */
    public function __construct(
        public readonly array $age,
        public readonly CurrencyEnum $currency_id,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d', type: CarbonImmutable::class)]
        public readonly CarbonImmutable $start_date,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d', type: CarbonImmutable::class)]
        public readonly CarbonImmutable $end_date,
    ) {}

    /** @return array<string, mixed> */
    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'age'   => ['required', 'array', 'min:1', 'max:10'],
            'age.*' => ['required', 'integer', 'min:18', 'max:70'],
            'currency_id' => ['required', Rule::enum(CurrencyEnum::class)],
            'start_date'  => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'end_date'    => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }
}
