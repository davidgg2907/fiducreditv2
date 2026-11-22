<?php

namespace App\Http\Requests;

use App\Models\CreditLoan;

final class StoreCreditLoanRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoan::class;
}
