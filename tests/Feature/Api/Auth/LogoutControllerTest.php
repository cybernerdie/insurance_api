<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

it('invalidates the token and returns a success message', function (): void {
    $user  = User::factory()->create();
    $token = JWTAuth::fromUser($user);

    $this->withToken($token)
        ->postJson(route('auth.logout'))
        ->assertStatus(200)
        ->assertJson(['message' => 'Logged out successfully.']);
});

it('returns 401 when not authenticated', function (): void {
    $this->postJson(route('auth.logout'))
        ->assertStatus(401);
});
