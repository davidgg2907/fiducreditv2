<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowStepRole;

final class UpdateCreditWorkflowStepRoleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowStepRole::class;
}
