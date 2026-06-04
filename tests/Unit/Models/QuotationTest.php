<?php

declare(strict_types=1);
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('belongs to a user', function (): void {
    $user      = User::factory()->create();
    $quotation = $user->quotations()->create([
        'ages'        => [28],
        'currency_id' => 'EUR',
        'start_date'  => now()->addDay(),
        'end_date'    => now()->addDays(10),
        'trip_length' => 10,
        'total'       => 16.20,
    ]);

    expect($quotation->user)->toBeInstanceOf(User::class)
        ->and($quotation->user->id)->toBe($user->id);
});
