<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoan;

final class UpdateCreditLoanRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoan::class;
}
