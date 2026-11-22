<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationConditionRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationConditionRequest;
use App\Http\Resources\Domain\CreditApplicationConditionResource;
use App\Models\Domain\CreditApplicationCondition;

final class CreditApplicationConditionController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationCondition::class;

    protected string $resourceClass = CreditApplicationConditionResource::class;

    protected string $storeRequestClass = StoreCreditApplicationConditionRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationConditionRequest::class;

    protected bool $allowDirectWrites = true;
}
