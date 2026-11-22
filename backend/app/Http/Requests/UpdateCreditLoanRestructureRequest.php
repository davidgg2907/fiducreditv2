<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanRestructure;

final class UpdateCreditLoanRestructureRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRestructure::class;
}
