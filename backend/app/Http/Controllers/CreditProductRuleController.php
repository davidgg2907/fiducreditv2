<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductRuleRequest;
use App\Http\Requests\UpdateCreditProductRuleRequest;
use App\Http\Resources\CreditProductRuleResource;
use App\Models\CreditProductRule;

final class CreditProductRuleController extends DomainResourceController
{
    protected string $modelClass = CreditProductRule::class;

    protected string $resourceClass = CreditProductRuleResource::class;

    protected string $storeRequestClass = StoreCreditProductRuleRequest::class;

    protected string $updateRequestClass = UpdateCreditProductRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
