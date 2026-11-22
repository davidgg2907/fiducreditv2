<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationCondition;

final class UpdateCreditApplicationConditionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationCondition::class;
}
