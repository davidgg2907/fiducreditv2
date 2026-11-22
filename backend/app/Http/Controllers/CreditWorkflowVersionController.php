<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowVersionRequest;
use App\Http\Requests\UpdateCreditWorkflowVersionRequest;
use App\Http\Resources\CreditWorkflowVersionResource;
use App\Models\CreditWorkflowVersion;

final class CreditWorkflowVersionController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowVersion::class;

    protected string $resourceClass = CreditWorkflowVersionResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowVersionRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
