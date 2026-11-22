<?php

namespace App\Http\Requests;

use App\Models\CreditLoanEvent;

final class UpdateCreditLoanEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanEvent::class;
}
