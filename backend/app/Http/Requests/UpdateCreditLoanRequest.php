<?php

namespace App\Http\Requests;

use App\Models\CreditLoan;

final class UpdateCreditLoanRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoan::class;
}
