<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductRule;

final class UpdateCreditProductRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductRule::class;
}
