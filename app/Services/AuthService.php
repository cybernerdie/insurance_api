<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\AuthTokenData;
use App\Data\LoginData;
use App\Data\RegisterData;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthService
{
    public function register(RegisterData $data): User
    {
        /** @var array<string, mixed> $attributes */
        $attributes = $data->toArray();

        return User::create($attributes);
    }

    public function login(LoginData $data): AuthTokenData
    {
        $token = JWTAuth::attempt($data->toArray());

        if (! $token) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        /** @var User $user */
        $user = JWTAuth::user();

        return new AuthTokenData(user: $user, token: $token);
    }

    public function logout(string $token): void
    {
        JWTAuth::setToken($token)->invalidate();
    }
}
