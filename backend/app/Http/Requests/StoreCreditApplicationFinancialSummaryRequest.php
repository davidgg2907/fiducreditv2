<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationFinancialSummary;

final class StoreCreditApplicationFinancialSummaryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialSummary::class;
}
