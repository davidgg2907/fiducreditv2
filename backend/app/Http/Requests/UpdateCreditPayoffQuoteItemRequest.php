<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPayoffQuoteItem;

final class UpdateCreditPayoffQuoteItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayoffQuoteItem::class;
}
