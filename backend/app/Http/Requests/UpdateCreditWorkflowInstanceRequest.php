<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowInstance;

final class UpdateCreditWorkflowInstanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowInstance::class;
}
