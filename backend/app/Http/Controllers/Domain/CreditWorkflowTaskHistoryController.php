<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowTaskHistoryRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowTaskHistoryRequest;
use App\Http\Resources\Domain\CreditWorkflowTaskHistoryResource;
use App\Models\Domain\CreditWorkflowTaskHistory;

final class CreditWorkflowTaskHistoryController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowTaskHistory::class;

    protected string $resourceClass = CreditWorkflowTaskHistoryResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowTaskHistoryRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowTaskHistoryRequest::class;

    protected bool $allowDirectWrites = false;
}
