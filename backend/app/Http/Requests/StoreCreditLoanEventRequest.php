<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanEvent;

final class StoreCreditLoanEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanEvent::class;
}
