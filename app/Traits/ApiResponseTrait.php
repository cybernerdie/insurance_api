<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    protected function successResponse(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $status);
    }
}
