<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationDecisionRequest;
use App\Http\Requests\UpdateCreditApplicationDecisionRequest;
use App\Http\Resources\CreditApplicationDecisionResource;
use App\Models\CreditApplicationDecision;

final class CreditApplicationDecisionController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationDecision::class;

    protected string $resourceClass = CreditApplicationDecisionResource::class;

    protected string $storeRequestClass = StoreCreditApplicationDecisionRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationDecisionRequest::class;

    protected bool $allowDirectWrites = false;
}
