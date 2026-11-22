<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowStep;

final class UpdateCreditWorkflowStepRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStep::class;
}
