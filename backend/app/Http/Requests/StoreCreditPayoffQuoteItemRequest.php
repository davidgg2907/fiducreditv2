<?php

namespace App\Http\Requests;

use App\Models\CreditPayoffQuoteItem;

final class StoreCreditPayoffQuoteItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayoffQuoteItem::class;
}
