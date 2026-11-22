<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowStep;

final class UpdateCreditWorkflowStepRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStep::class;
}
