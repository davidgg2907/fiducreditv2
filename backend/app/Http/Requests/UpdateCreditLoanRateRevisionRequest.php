<?php

namespace App\Http\Requests;

use App\Models\CreditLoanRateRevision;

final class UpdateCreditLoanRateRevisionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRateRevision::class;
}
