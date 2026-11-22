<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanBalance;

final class UpdateCreditLoanBalanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanBalance::class;
}
