<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowVersionRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowVersionRequest;
use App\Http\Resources\Domain\CreditWorkflowVersionResource;
use App\Models\Domain\CreditWorkflowVersion;

final class CreditWorkflowVersionController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowVersion::class;

    protected string $resourceClass = CreditWorkflowVersionResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowVersionRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
