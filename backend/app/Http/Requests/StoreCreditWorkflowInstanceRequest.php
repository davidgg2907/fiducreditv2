<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowInstance;

final class StoreCreditWorkflowInstanceRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowInstance::class;
}
