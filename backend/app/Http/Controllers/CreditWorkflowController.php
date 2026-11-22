<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowRequest;
use App\Http\Requests\UpdateCreditWorkflowRequest;
use App\Http\Resources\CreditWorkflowResource;
use App\Models\CreditWorkflow;

final class CreditWorkflowController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflow::class;

    protected string $resourceClass = CreditWorkflowResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowRequest::class;

    protected bool $allowDirectWrites = true;
}
