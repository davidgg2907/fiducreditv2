<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditDocumentValidationRuleRequest;
use App\Http\Requests\UpdateCreditDocumentValidationRuleRequest;
use App\Http\Resources\CreditDocumentValidationRuleResource;
use App\Models\CreditDocumentValidationRule;

final class CreditDocumentValidationRuleController extends DomainResourceController
{
    protected string $modelClass = CreditDocumentValidationRule::class;

    protected string $resourceClass = CreditDocumentValidationRuleResource::class;

    protected string $storeRequestClass = StoreCreditDocumentValidationRuleRequest::class;

    protected string $updateRequestClass = UpdateCreditDocumentValidationRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
