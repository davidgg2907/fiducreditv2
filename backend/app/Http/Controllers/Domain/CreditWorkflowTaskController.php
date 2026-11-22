<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowTaskRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowTaskRequest;
use App\Http\Resources\Domain\CreditWorkflowTaskResource;
use App\Models\Domain\CreditWorkflowTask;

final class CreditWorkflowTaskController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowTask::class;

    protected string $resourceClass = CreditWorkflowTaskResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowTaskRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowTaskRequest::class;

    protected bool $allowDirectWrites = false;
}
