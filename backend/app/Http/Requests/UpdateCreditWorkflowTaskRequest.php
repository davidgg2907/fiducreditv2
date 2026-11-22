<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowTask;

final class UpdateCreditWorkflowTaskRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTask::class;
}
