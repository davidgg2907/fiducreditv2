<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowStepRule;

final class StoreCreditWorkflowStepRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStepRule::class;
}
