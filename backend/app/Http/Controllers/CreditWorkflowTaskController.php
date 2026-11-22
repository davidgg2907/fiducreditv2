<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowTaskRequest;
use App\Http\Requests\UpdateCreditWorkflowTaskRequest;
use App\Http\Resources\CreditWorkflowTaskResource;
use App\Models\CreditWorkflowTask;

final class CreditWorkflowTaskController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowTask::class;

    protected string $resourceClass = CreditWorkflowTaskResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowTaskRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowTaskRequest::class;

    protected bool $allowDirectWrites = false;
}
