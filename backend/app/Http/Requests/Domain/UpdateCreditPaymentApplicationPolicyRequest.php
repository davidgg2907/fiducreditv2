<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentApplicationPolicy;

final class UpdateCreditPaymentApplicationPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentApplicationPolicy::class;
}
