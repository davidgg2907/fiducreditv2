<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowRequest;
use App\Http\Resources\Domain\CreditWorkflowResource;
use App\Models\Domain\CreditWorkflow;

final class CreditWorkflowController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflow::class;

    protected string $resourceClass = CreditWorkflowResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowRequest::class;

    protected bool $allowDirectWrites = true;
}
