<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflow;

final class UpdateCreditWorkflowRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflow::class;
}
