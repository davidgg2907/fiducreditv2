<?php

namespace App\Http\Requests;

use App\Models\CreditDocumentValidationRule;

final class UpdateCreditDocumentValidationRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentValidationRule::class;
}
