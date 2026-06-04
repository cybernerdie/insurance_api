<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Data\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private readonly AuthService $service) {}

    public function __invoke(LoginData $data): JsonResponse
    {
        $result = $this->service->login($data);

        return $this->successResponse([
            'user'  => new UserResource($result->user),
            'token' => $result->token,
        ]);
    }
}
