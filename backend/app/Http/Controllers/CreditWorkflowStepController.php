<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowStepRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowStepRequest;
use App\Http\Resources\Domain\CreditWorkflowStepResource;
use App\Models\Domain\CreditWorkflowStep;

final class CreditWorkflowStepController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowStep::class;

    protected string $resourceClass = CreditWorkflowStepResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowStepRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowStepRequest::class;

    protected bool $allowDirectWrites = true;
}
