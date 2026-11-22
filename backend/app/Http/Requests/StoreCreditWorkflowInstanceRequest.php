<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowInstance;

final class StoreCreditWorkflowInstanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowInstance::class;
}
