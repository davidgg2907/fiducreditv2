<?php

namespace App\Http\Requests;

use App\Models\CreditLoanRestructure;

final class StoreCreditLoanRestructureRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanRestructure::class;
}
