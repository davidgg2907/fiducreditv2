<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationFinancialSummary;

final class UpdateCreditApplicationFinancialSummaryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationFinancialSummary::class;
}
