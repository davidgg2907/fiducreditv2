<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentApplicationPolicy;

final class StoreCreditPaymentApplicationPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPolicy::class;
}
