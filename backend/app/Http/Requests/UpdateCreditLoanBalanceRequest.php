<?php

namespace App\Http\Requests;

use App\Models\CreditLoanBalance;

final class UpdateCreditLoanBalanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanBalance::class;
}
