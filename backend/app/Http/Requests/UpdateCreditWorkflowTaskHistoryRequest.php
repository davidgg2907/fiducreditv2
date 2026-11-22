<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowTaskHistory;

final class UpdateCreditWorkflowTaskHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTaskHistory::class;
}
