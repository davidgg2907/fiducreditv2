<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanEvent;

final class UpdateCreditLoanEventRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanEvent::class;
}
