<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowTransition;

final class StoreCreditWorkflowTransitionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTransition::class;
}
