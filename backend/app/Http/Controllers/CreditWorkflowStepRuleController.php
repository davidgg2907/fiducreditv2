<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditWorkflowStepRuleRequest;
use App\Http\Requests\UpdateCreditWorkflowStepRuleRequest;
use App\Http\Resources\CreditWorkflowStepRuleResource;
use App\Models\CreditWorkflowStepRule;

final class CreditWorkflowStepRuleController extends DomainResourceController
{
    protected string $modelClass = CreditWorkflowStepRule::class;

    protected string $resourceClass = CreditWorkflowStepRuleResource::class;

    protected string $storeRequestClass = StoreCreditWorkflowStepRuleRequest::class;

    protected string $updateRequestClass = UpdateCreditWorkflowStepRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
