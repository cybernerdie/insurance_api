<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a user and returns their data', function (): void {
    $this->postJson(route('auth.register'), [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])
        ->assertStatus(201)
        ->assertJsonStructure(['id', 'name', 'email'])
        ->assertJson(['name' => 'John Doe', 'email' => 'john@example.com']);
});

it('persists the user to the database', function (): void {
    $this->postJson(route('auth.register'), [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

it('does not return a token on register', function (): void {
    $response = $this->postJson(route('auth.register'), [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ]);

    expect($response->json('token'))->toBeNull();
});

it('returns 422 when name is missing', function (): void {
    $this->postJson(route('auth.register'), [
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertStatus(422)->assertJsonValidationErrors('name');
});

it('returns 422 when email is already taken', function (): void {
    User::factory()->create(['email' => 'john@example.com']);

    $this->postJson(route('auth.register'), [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertStatus(422)->assertJsonValidationErrors('email');
});

it('returns 422 when password is too short', function (): void {
    $this->postJson(route('auth.register'), [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'short',
        'password_confirmation' => 'short',
    ])->assertStatus(422)->assertJsonValidationErrors('password');
});

it('returns 422 when passwords do not match', function (): void {
    $this->postJson(route('auth.register'), [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'different123',
    ])->assertStatus(422)->assertJsonValidationErrors('password');
});
