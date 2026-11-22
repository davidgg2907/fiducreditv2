<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowSlaRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowSlaRequest;
use App\Http\Resources\Domain\CreditWorkflowSlaResource;
use App\Models\Domain\CreditWorkflowSla;

final class CreditWorkflowSlaController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowSla::class;

    protected string $resourceClass = CreditWorkflowSlaResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowSlaRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowSlaRequest::class;

    protected bool $allowDirectWrites = true;
}
