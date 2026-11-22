<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowStepRequest;
use App\Http\Requests\UpdateCreditWorkflowStepRequest;
use App\Http\Resources\CreditWorkflowStepResource;
use App\Models\CreditWorkflowStep;

final class CreditWorkflowStepController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowStep::class;

    protected string $resourceClass = CreditWorkflowStepResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowStepRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowStepRequest::class;

    protected bool $allowDirectWrites = true;
}
