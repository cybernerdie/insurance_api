<?php

declare(strict_types=1);

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Data\LoginData;
use App\Data\RegisterData;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    $this->service = new AuthService();
});

it('creates a user on register', function (): void {
    $data = RegisterData::from([
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $user = $this->service->register($data);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->email)->toBe('john@example.com');

    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

it('returns an AuthTokenData with user and token on login', function (): void {
    User::factory()->create([
        'email'    => 'john@example.com',
        'password' => bcrypt('password123'),
    ]);

    $data   = LoginData::from(['email' => 'john@example.com', 'password' => 'password123']);
    $result = $this->service->login($data);

    expect($result->user->email)->toBe('john@example.com')
        ->and($result->token)->toBeString()->not->toBeEmpty();
});

it('throws ValidationException for invalid credentials', function (): void {
    User::factory()->create(['email' => 'john@example.com']);

    $data = LoginData::from(['email' => 'john@example.com', 'password' => 'wrong']);

    expect(fn () => $this->service->login($data))->toThrow(ValidationException::class);
});

it('invalidates the JWT token on logout', function (): void {
    $user  = User::factory()->create();
    $token = JWTAuth::fromUser($user);

    $this->service->logout($token);

    JWTAuth::setToken($token);
    expect(fn () => JWTAuth::parseToken()->authenticate())
        ->toThrow(JWTException::class);
});
