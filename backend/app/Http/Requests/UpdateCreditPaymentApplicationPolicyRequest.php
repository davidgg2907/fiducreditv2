<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentApplicationPolicy;

final class UpdateCreditPaymentApplicationPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPolicy::class;
}
