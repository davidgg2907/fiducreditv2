<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationFinancialItem;

final class UpdateCreditApplicationFinancialItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialItem::class;
}
