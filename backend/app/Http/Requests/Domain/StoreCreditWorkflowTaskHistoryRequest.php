<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowTaskHistory;

final class StoreCreditWorkflowTaskHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowTaskHistory::class;
}
