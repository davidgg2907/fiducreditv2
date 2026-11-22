<?php

namespace App\Http\Requests;

use App\Models\CreditDocumentValidationRule;

final class StoreCreditDocumentValidationRuleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentValidationRule::class;
}
