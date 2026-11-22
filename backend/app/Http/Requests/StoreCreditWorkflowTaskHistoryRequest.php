<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowTaskHistory;

final class StoreCreditWorkflowTaskHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTaskHistory::class;
}
