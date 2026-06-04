<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Data\RegisterData;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private readonly AuthService $service) {}

    public function __invoke(RegisterData $data): JsonResponse
    {
        return $this->successResponse(new UserResource($this->service->register($data)), Response::HTTP_CREATED);
    }
}
