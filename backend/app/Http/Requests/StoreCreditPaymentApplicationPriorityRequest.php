<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentApplicationPriority;

final class StoreCreditPaymentApplicationPriorityRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPriority::class;
}
