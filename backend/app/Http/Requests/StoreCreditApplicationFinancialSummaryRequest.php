<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationFinancialSummary;

final class StoreCreditApplicationFinancialSummaryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialSummary::class;
}
