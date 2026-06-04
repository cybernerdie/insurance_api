<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\CurrencyEnum;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function __invoke(): View
    {
        return view('quotation.index', [
            'currencies' => CurrencyEnum::cases(),
        ]);
    }
}
