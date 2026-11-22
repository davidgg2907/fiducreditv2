<?php

namespace App\Http\Requests;

use App\Models\CreditPayoffQuote;

final class UpdateCreditPayoffQuoteRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayoffQuote::class;
}
