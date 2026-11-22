<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationFinancialItem;

final class StoreCreditApplicationFinancialItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialItem::class;
}
