<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDocumentValidationRule;

final class StoreCreditDocumentValidationRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentValidationRule::class;
}
