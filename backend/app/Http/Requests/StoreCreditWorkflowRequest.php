<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflow;

final class StoreCreditWorkflowRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflow::class;
}
