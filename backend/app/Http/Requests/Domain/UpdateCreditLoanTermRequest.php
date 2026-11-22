<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanTerm;

final class UpdateCreditLoanTermRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanTerm::class;
}
