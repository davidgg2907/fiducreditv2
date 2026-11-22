<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditWorkflowStepRuleRequest;
use App\Http\Requests\Domain\UpdateCreditWorkflowStepRuleRequest;
use App\Http\Resources\Domain\CreditWorkflowStepRuleResource;
use App\Models\Domain\CreditWorkflowStepRule;

final class CreditWorkflowStepRuleController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowStepRule::class;

    protected string $resourceClass = CreditWorkflowStepRuleResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowStepRuleRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowStepRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
