<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationFinancialItem;

final class StoreCreditApplicationFinancialItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialItem::class;
}
