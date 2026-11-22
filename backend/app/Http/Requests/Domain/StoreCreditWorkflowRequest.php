<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflow;

final class StoreCreditWorkflowRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflow::class;
}
