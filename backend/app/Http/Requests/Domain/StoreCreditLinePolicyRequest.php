<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLinePolicy;

final class StoreCreditLinePolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLinePolicy::class;
}
