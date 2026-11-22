<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanAdjustment;

final class UpdateCreditLoanAdjustmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanAdjustment::class;
}
