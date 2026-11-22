<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentApplicationPriority;

final class UpdateCreditPaymentApplicationPriorityRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPriority::class;
}
