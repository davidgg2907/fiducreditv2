<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowTask;

final class UpdateCreditWorkflowTaskRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTask::class;
}
