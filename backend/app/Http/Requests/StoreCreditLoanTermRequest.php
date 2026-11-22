<?php

namespace App\Http\Requests;

use App\Models\CreditLoanTerm;

final class StoreCreditLoanTermRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanTerm::class;
}
