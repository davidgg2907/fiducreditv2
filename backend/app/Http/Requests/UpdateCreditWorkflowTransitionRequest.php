<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowTransition;

final class UpdateCreditWorkflowTransitionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTransition::class;
}
