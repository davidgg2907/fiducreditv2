<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentApplicationPriority;

final class StoreCreditPaymentApplicationPriorityRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPriority::class;
}
