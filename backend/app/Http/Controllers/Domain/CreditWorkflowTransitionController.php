<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowTransitionRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowTransitionRequest;
use App\Http\Resources\Domain\CreditWorkflowTransitionResource;
use App\Models\Domain\CreditWorkflowTransition;

final class CreditWorkflowTransitionController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowTransition::class;

    protected string $resourceClass = CreditWorkflowTransitionResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowTransitionRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowTransitionRequest::class;

    protected bool $allowDirectWrites = true;
}
