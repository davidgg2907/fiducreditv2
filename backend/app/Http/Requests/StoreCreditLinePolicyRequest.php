<?php

namespace App\Http\Requests;

use App\Models\CreditLinePolicy;

final class StoreCreditLinePolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLinePolicy::class;
}
