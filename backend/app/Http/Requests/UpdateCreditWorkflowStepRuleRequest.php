<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowStepRule;

final class UpdateCreditWorkflowStepRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStepRule::class;
}
