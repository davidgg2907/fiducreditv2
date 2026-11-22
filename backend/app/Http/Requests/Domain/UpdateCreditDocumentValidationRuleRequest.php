<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDocumentValidationRule;

final class UpdateCreditDocumentValidationRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentValidationRule::class;
}
