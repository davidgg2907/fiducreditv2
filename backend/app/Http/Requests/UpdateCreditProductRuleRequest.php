<?php

namespace App\Http\Requests;

use App\Models\CreditProductRule;

final class UpdateCreditProductRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductRule::class;
}
