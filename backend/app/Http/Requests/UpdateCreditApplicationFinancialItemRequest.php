<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationFinancialItem;

final class UpdateCreditApplicationFinancialItemRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialItem::class;
}
