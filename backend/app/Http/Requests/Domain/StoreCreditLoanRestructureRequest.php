<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanRestructure;

final class StoreCreditLoanRestructureRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRestructure::class;
}
