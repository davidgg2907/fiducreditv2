<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationFinancialSummary;

final class UpdateCreditApplicationFinancialSummaryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialSummary::class;
}
