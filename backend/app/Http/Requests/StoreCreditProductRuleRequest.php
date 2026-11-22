<?php

namespace App\Http\Requests;

use App\Models\CreditProductRule;

final class StoreCreditProductRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductRule::class;
}
