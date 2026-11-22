<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPayoffQuote;

final class UpdateCreditPayoffQuoteRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayoffQuote::class;
}
