<?php

namespace App\Http\Requests;

use App\Models\CreditLoanAdjustment;

final class StoreCreditLoanAdjustmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanAdjustment::class;
}
