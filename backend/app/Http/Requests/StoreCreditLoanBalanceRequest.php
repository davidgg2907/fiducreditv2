<?php

namespace App\Http\Requests;

use App\Models\CreditLoanBalance;

final class StoreCreditLoanBalanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanBalance::class;
}
