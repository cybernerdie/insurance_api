<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class LoginData extends Data
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    /** @return array<string, mixed> */
    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
