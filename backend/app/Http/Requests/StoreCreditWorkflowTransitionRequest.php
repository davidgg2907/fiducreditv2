<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowTransition;

final class StoreCreditWorkflowTransitionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTransition::class;
}
