<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowStep;

final class StoreCreditWorkflowStepRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStep::class;
}
