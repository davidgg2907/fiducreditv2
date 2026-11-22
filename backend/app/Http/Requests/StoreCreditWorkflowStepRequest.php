<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowStep;

final class StoreCreditWorkflowStepRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStep::class;
}
