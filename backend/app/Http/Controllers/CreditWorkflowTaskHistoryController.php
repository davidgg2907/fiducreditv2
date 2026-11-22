<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowTaskHistoryRequest;
use App\Http\Requests\UpdateCreditWorkflowTaskHistoryRequest;
use App\Http\Resources\CreditWorkflowTaskHistoryResource;
use App\Models\CreditWorkflowTaskHistory;

final class CreditWorkflowTaskHistoryController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowTaskHistory::class;

    protected string $resourceClass = CreditWorkflowTaskHistoryResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowTaskHistoryRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowTaskHistoryRequest::class;

    protected bool $allowDirectWrites = false;
}
