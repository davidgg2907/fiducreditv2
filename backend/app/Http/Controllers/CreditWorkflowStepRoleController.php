<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowStepRoleRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowStepRoleRequest;
use App\Http\Resources\Domain\CreditWorkflowStepRoleResource;
use App\Models\Domain\CreditWorkflowStepRole;

final class CreditWorkflowStepRoleController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowStepRole::class;

    protected string $resourceClass = CreditWorkflowStepRoleResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowStepRoleRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowStepRoleRequest::class;

    protected bool $allowDirectWrites = true;
}
