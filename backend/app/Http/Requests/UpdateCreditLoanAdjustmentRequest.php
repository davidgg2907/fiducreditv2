<?php

namespace App\Http\Requests;

use App\Models\CreditLoanAdjustment;

final class UpdateCreditLoanAdjustmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanAdjustment::class;
}
