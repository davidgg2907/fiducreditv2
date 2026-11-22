<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowTaskHistory;

final class UpdateCreditWorkflowTaskHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTaskHistory::class;
}
