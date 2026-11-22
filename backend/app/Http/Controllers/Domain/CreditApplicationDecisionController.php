<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationDecisionRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationDecisionRequest;
use App\Http\Resources\Domain\CreditApplicationDecisionResource;
use App\Models\Domain\CreditApplicationDecision;

final class CreditApplicationDecisionController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationDecision::class;

    protected string $resourceClass = CreditApplicationDecisionResource::class;

    protected string $storeRequestClass = StoreCreditApplicationDecisionRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationDecisionRequest::class;

    protected bool $allowDirectWrites = false;
}
