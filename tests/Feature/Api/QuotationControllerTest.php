<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function validPayload(): array
{
    return [
        'age'         => [28, 35],
        'currency_id' => 'EUR',
        'start_date'  => now()->addDay()->format('Y-m-d'),
        'end_date'    => now()->addDays(30)->format('Y-m-d'),
    ];
}

it('returns a quotation for authenticated requests with valid data', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), validPayload())
        ->assertStatus(201)
        ->assertJsonStructure(['quotation_id', 'total', 'currency_id'])
        ->assertJson(['total' => '117.00', 'currency_id' => 'EUR']);
});

it('returns 401 for unauthenticated requests', function (): void {
    $this->postJson(route('quotation.store'), validPayload())
        ->assertStatus(401);
});

it('returns 422 when age is missing', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), ['age' => []]))
        ->assertStatus(422)
        ->assertJsonValidationErrors('age');
});

it('returns 422 when age is out of range', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), ['age' => [17, 35]]))
        ->assertStatus(422)
        ->assertJsonValidationErrors('age.0');
});

it('returns 422 when currency is invalid', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), ['currency_id' => 'JPY']))
        ->assertStatus(422)
        ->assertJsonValidationErrors('currency_id');
});

it('returns 422 when end_date is before start_date', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), [
            'start_date' => '2020-10-30',
            'end_date'   => '2020-10-01',
        ]))
        ->assertStatus(422)
        ->assertJsonValidationErrors('end_date');
});

it('returns 422 when start_date is in the past', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), ['start_date' => '2020-01-01']))
        ->assertStatus(422)
        ->assertJsonValidationErrors('start_date');
});

it('returns 422 when age contains a non-integer', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), ['age' => ['abc', 35]]))
        ->assertStatus(422)
        ->assertJsonValidationErrors('age.0');
});

it('returns 422 when more than 10 travellers are provided', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), array_merge(validPayload(), ['age' => range(18, 29)]))
        ->assertStatus(422)
        ->assertJsonValidationErrors('age');
});

it('returns 422 when required fields are missing', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['age', 'currency_id', 'start_date', 'end_date']);
});

it('persists the quotation to the database', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), validPayload());

    $this->assertDatabaseHas('quotations', [
        'user_id'     => $user->id,
        'currency_id' => 'EUR',
    ]);
});

it('returns the correct total for the worked example', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user, 'api')
        ->postJson(route('quotation.store'), [
            'age'         => [28, 35],
            'currency_id' => 'EUR',
            'start_date'  => now()->addDay()->format('Y-m-d'),
            'end_date'    => now()->addDays(30)->format('Y-m-d'),
        ])
        ->assertStatus(201)
        ->assertJson(['total' => '117.00', 'currency_id' => 'EUR']);
});

it('returns a unique quotation_id for each request', function (): void {
    $user = User::factory()->create();

    $first  = $this->actingAs($user, 'api')->postJson(route('quotation.store'), validPayload());
    $second = $this->actingAs($user, 'api')->postJson(route('quotation.store'), validPayload());

    expect($first->json('quotation_id'))->not->toBe($second->json('quotation_id'));
});
