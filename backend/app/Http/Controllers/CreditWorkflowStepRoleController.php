<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowStepRoleRequest;
use App\Http\Requests\UpdateCreditWorkflowStepRoleRequest;
use App\Http\Resources\CreditWorkflowStepRoleResource;
use App\Models\CreditWorkflowStepRole;

final class CreditWorkflowStepRoleController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowStepRole::class;

    protected string $resourceClass = CreditWorkflowStepRoleResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowStepRoleRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowStepRoleRequest::class;

    protected bool $allowDirectWrites = true;
}
