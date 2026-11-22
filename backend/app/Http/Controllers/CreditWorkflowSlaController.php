<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowSlaRequest;
use App\Http\Requests\UpdateCreditWorkflowSlaRequest;
use App\Http\Resources\CreditWorkflowSlaResource;
use App\Models\CreditWorkflowSla;

final class CreditWorkflowSlaController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowSla::class;

    protected string $resourceClass = CreditWorkflowSlaResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowSlaRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowSlaRequest::class;

    protected bool $allowDirectWrites = true;
}
