<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowTransitionRequest;
use App\Http\Requests\UpdateCreditWorkflowTransitionRequest;
use App\Http\Resources\CreditWorkflowTransitionResource;
use App\Models\CreditWorkflowTransition;

final class CreditWorkflowTransitionController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowTransition::class;

    protected string $resourceClass = CreditWorkflowTransitionResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowTransitionRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowTransitionRequest::class;

    protected bool $allowDirectWrites = true;
}
