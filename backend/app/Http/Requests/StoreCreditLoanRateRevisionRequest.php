<?php

namespace App\Http\Requests;

use App\Models\CreditLoanRateRevision;

final class StoreCreditLoanRateRevisionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRateRevision::class;
}
