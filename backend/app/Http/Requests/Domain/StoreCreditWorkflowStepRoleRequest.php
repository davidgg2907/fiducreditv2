<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowStepRole;

final class StoreCreditWorkflowStepRoleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStepRole::class;
}
