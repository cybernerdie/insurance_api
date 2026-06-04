<?php

declare(strict_types=1);

use App\Enums\AgeLoadEnum;

it('maps boundary ages to correct brackets', function (int $age, AgeLoadEnum $expected): void {
    expect(AgeLoadEnum::fromAge($age))->toBe($expected);
})->with([
    'lower bound (18)'        => [18, AgeLoadEnum::YOUNG_ADULT],
    'upper bound of 18-30'    => [30, AgeLoadEnum::YOUNG_ADULT],
    'lower bound of 31-40'    => [31, AgeLoadEnum::ADULT],
    'upper bound of 31-40'    => [40, AgeLoadEnum::ADULT],
    'lower bound of 41-50'    => [41, AgeLoadEnum::MIDDLE_AGED],
    'upper bound of 41-50'    => [50, AgeLoadEnum::MIDDLE_AGED],
    'lower bound of 51-60'    => [51, AgeLoadEnum::SENIOR],
    'upper bound of 51-60'    => [60, AgeLoadEnum::SENIOR],
    'lower bound of 61-70'    => [61, AgeLoadEnum::ELDER],
    'upper bound (70)'        => [70, AgeLoadEnum::ELDER],
]);

it('returns correct load factor for each bracket', function (AgeLoadEnum $bracket, float $expected): void {
    expect($bracket->load())->toBe($expected);
})->with([
    'YOUNG_ADULT' => [AgeLoadEnum::YOUNG_ADULT, 0.6],
    'ADULT'       => [AgeLoadEnum::ADULT, 0.7],
    'MIDDLE_AGED' => [AgeLoadEnum::MIDDLE_AGED, 0.8],
    'SENIOR'      => [AgeLoadEnum::SENIOR, 0.9],
    'ELDER'       => [AgeLoadEnum::ELDER, 1.0],
]);

it('returns correct load directly from age', function (int $age, float $expected): void {
    expect(AgeLoadEnum::loadForAge($age))->toBe($expected);
})->with([
    'age 25' => [25, 0.6],
    'age 35' => [35, 0.7],
    'age 45' => [45, 0.8],
    'age 55' => [55, 0.9],
    'age 65' => [65, 1.0],
]);
