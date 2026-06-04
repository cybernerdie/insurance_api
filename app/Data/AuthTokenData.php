<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;

readonly class AuthTokenData
{
    public function __construct(
        public User $user,
        public string $token,
    ) {}
}
