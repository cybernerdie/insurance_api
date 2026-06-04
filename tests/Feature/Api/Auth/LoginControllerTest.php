<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns user and token on successful login', function (): void {
    User::factory()->create([
        'email'    => 'john@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->postJson(route('auth.login'), [
        'email'    => 'john@example.com',
        'password' => 'password123',
    ])
        ->assertStatus(200)
        ->assertJsonStructure(['user' => ['id', 'name', 'email'], 'token']);
});

it('returns a JWT token on login', function (): void {
    User::factory()->create([
        'email'    => 'john@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson(route('auth.login'), [
        'email'    => 'john@example.com',
        'password' => 'password123',
    ]);

    $token = $response->json('token');

    expect($token)->toBeString()
        ->and(explode('.', (string) $token))->toHaveCount(3);
});

it('returns 422 for invalid credentials', function (): void {
    User::factory()->create(['email' => 'john@example.com']);

    $this->postJson(route('auth.login'), [
        'email'    => 'john@example.com',
        'password' => 'wrong-password',
    ])->assertStatus(422)->assertJsonValidationErrors('email');
});

it('returns 422 when email is missing', function (): void {
    $this->postJson(route('auth.login'), ['password' => 'password123'])
        ->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

it('returns 422 when password is missing', function (): void {
    $this->postJson(route('auth.login'), ['email' => 'john@example.com'])
        ->assertStatus(422)
        ->assertJsonValidationErrors('password');
});
