<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowInstanceRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowInstanceRequest;
use App\Http\Resources\Domain\CreditWorkflowInstanceResource;
use App\Models\Domain\CreditWorkflowInstance;

final class CreditWorkflowInstanceController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowInstance::class;

    protected string $resourceClass = CreditWorkflowInstanceResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowInstanceRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowInstanceRequest::class;

    protected bool $allowDirectWrites = false;
}
