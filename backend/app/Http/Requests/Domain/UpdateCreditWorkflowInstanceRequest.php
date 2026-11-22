<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowInstance;

final class UpdateCreditWorkflowInstanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowInstance::class;
}
