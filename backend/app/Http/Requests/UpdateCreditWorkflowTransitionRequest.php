<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowTransition;

final class UpdateCreditWorkflowTransitionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTransition::class;
}
