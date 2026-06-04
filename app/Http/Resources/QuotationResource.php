<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Override;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Quotation */
class QuotationResource extends JsonResource
{
    public static $wrap;

    /** @return array<string, mixed> */
    #[Override]
    public function toArray(Request $_request): array
    {
        return [
            'quotation_id' => $this->id,
            'total'        => number_format((float) $this->total, 2),
            'currency_id'  => $this->currency_id,
        ];
    }
}
