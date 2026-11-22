<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowStepRole;

final class UpdateCreditWorkflowStepRoleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStepRole::class;
}
