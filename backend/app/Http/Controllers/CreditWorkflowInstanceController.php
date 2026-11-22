<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowInstanceRequest;
use App\Http\Requests\UpdateCreditWorkflowInstanceRequest;
use App\Http\Resources\CreditWorkflowInstanceResource;
use App\Models\CreditWorkflowInstance;

final class CreditWorkflowInstanceController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowInstance::class;

    protected string $resourceClass = CreditWorkflowInstanceResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowInstanceRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowInstanceRequest::class;

    protected bool $allowDirectWrites = false;
}
