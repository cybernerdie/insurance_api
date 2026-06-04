<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private readonly AuthService $service) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->service->logout((string) $request->bearerToken());

        return $this->successResponse(['message' => 'Logged out successfully.']);
    }
}
