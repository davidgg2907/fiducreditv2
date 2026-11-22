<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationConditionRequest;
use App\Http\Requests\UpdateCreditApplicationConditionRequest;
use App\Http\Resources\CreditApplicationConditionResource;
use App\Models\CreditApplicationCondition;

final class CreditApplicationConditionController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationCondition::class;

    protected string $resourceClass = CreditApplicationConditionResource::class;

    protected string $storeRequestClass = StoreCreditApplicationConditionRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationConditionRequest::class;

    protected bool $allowDirectWrites = true;
}
