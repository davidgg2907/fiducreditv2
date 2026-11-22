<?php

namespace App\Http\Requests;

use App\Models\CreditLoanTerm;

final class UpdateCreditLoanTermRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanTerm::class;
}
