<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductRuleRequest;
use App\Http\Requests\Domain\UpdateCreditProductRuleRequest;
use App\Http\Resources\Domain\CreditProductRuleResource;
use App\Models\Domain\CreditProductRule;

final class CreditProductRuleController extends DomainResourceController
{
    protected string $modelClass = CreditProductRule::class;

    protected string $resourceClass = CreditProductRuleResource::class;

    protected string $storeRequestClass = StoreCreditProductRuleRequest::class;

    protected string $updateRequestClass = UpdateCreditProductRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
