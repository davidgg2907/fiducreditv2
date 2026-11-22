<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanRateRevision;

final class StoreCreditLoanRateRevisionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRateRevision::class;
}
