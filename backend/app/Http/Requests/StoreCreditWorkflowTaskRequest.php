<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowTask;

final class StoreCreditWorkflowTaskRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTask::class;
}
