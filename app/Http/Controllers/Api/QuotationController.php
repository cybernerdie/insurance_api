<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Data\QuotationData;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuotationResource;
use App\Models\User;
use App\Services\QuotationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private readonly QuotationService $service) {}

    public function __invoke(QuotationData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth('api')->user();

        $quotation = $this->service->createForUser($data, $user);

        return $this->successResponse(new QuotationResource($quotation), Response::HTTP_CREATED);
    }
}
