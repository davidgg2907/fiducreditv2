<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanBalance;

final class StoreCreditLoanBalanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanBalance::class;
}
