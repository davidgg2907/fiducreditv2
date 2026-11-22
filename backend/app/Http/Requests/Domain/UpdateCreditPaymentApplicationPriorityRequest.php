<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentApplicationPriority;

final class UpdateCreditPaymentApplicationPriorityRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPriority::class;
}
