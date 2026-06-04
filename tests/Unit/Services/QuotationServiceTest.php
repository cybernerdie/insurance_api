<?php

declare(strict_types=1);

use App\Data\QuotationData;
use App\Enums\CurrencyEnum;
use App\Models\User;
use App\Services\QuotationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->service = new QuotationService();
});

it('calculates the correct total for a single age', function (): void {
    $data = QuotationData::from([
        'age'         => [28],
        'currency_id' => CurrencyEnum::USD->value,
        'start_date'  => '2020-10-01',
        'end_date'    => '2020-10-30',
    ]);

    $quotation = $this->service->createForUser($data, $this->user);

    expect($quotation->total)->toBe('54.00');
});

it('calculates the correct total for multiple ages (worked example)', function (): void {
    $data = QuotationData::from([
        'age'         => [28, 35],
        'currency_id' => CurrencyEnum::EUR->value,
        'start_date'  => '2020-10-01',
        'end_date'    => '2020-10-30',
    ]);

    $quotation = $this->service->createForUser($data, $this->user);

    expect($quotation->total)->toBe('117.00');
});

it('counts trip length inclusively', function (): void {
    $data = QuotationData::from([
        'age'         => [30],
        'currency_id' => CurrencyEnum::GBP->value,
        'start_date'  => '2024-01-01',
        'end_date'    => '2024-01-01',
    ]);

    $quotation = $this->service->createForUser($data, $this->user);

    expect($quotation->trip_length)->toBe(1)
        ->and($quotation->total)->toBe('1.80');
});

it('applies the correct load for each age bracket', function (int $age, int $days, float $expectedTotal): void {
    $data = QuotationData::from([
        'age'         => [$age],
        'currency_id' => CurrencyEnum::USD->value,
        'start_date'  => '2024-01-01',
        'end_date'    => '2024-01-' . str_pad((string) $days, 2, '0', STR_PAD_LEFT),
    ]);

    $quotation = $this->service->createForUser($data, $this->user);

    expect((float) $quotation->total)->toBe($expectedTotal);
})->with([
    '18-30 bracket' => [28, 10, 18.0],
    '31-40 bracket' => [35, 10, 21.0],
    '41-50 bracket' => [45, 10, 24.0],
    '51-60 bracket' => [55, 10, 27.0],
    '61-70 bracket' => [65, 10, 30.0],
]);
