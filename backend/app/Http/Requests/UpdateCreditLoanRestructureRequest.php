<?php

namespace App\Http\Requests;

use App\Models\CreditLoanRestructure;

final class UpdateCreditLoanRestructureRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRestructure::class;
}
