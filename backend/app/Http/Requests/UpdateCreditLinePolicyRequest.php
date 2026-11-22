<?php

namespace App\Http\Requests;

use App\Models\CreditLinePolicy;

final class UpdateCreditLinePolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLinePolicy::class;
}
