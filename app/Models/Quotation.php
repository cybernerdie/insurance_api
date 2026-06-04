<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CurrencyEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property int $id
 * @property int $user_id
 * @property array<int, int> $ages
 * @property CurrencyEnum $currency_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $trip_length
 * @property string $total
 */
#[Fillable(['ages', 'currency_id', 'start_date', 'end_date', 'trip_length', 'total'])]
class Quotation extends Model
{
    /** @return array<string, string> */
    #[Override]
    protected function casts(): array
    {
        return [
            'ages'        => 'array',
            'currency_id' => CurrencyEnum::class,
            'total'       => 'decimal:2',
            'start_date'  => 'date',
            'end_date'    => 'date',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
