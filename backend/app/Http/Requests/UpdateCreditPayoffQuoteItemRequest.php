<?php

namespace App\Http\Requests;

use App\Models\CreditPayoffQuoteItem;

final class UpdateCreditPayoffQuoteItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayoffQuoteItem::class;
}
