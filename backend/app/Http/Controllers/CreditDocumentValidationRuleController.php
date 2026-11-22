<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditDocumentValidationRuleRequest;
use App\Http\Requests\Domain\UpdateCreditDocumentValidationRuleRequest;
use App\Http\Resources\Domain\CreditDocumentValidationRuleResource;
use App\Models\Domain\CreditDocumentValidationRule;

final class CreditDocumentValidationRuleController extends DomainResourceController
{
    protected string $modelClass = CreditDocumentValidationRule::class;

    protected string $resourceClass = CreditDocumentValidationRuleResource::class;

    protected string $storeRequestClass = StoreCreditDocumentValidationRuleRequest::class;

    protected string $updateRequestClass = UpdateCreditDocumentValidationRuleRequest::class;

    protected bool $allowDirectWrites = true;
}
