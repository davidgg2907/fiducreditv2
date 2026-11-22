<?php

namespace App\Http\Requests;

use App\Models\CreditLoanEvent;

final class StoreCreditLoanEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanEvent::class;
}
