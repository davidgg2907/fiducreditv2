<?php

namespace App\Http\Requests;

use App\Models\CreditPayoffQuote;

final class StoreCreditPayoffQuoteRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayoffQuote::class;
}
