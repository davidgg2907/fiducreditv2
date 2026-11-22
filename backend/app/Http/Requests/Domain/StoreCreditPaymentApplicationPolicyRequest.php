<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentApplicationPolicy;

final class StoreCreditPaymentApplicationPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPolicy::class;
}
