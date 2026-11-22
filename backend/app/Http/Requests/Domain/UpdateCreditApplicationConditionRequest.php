<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationCondition;

final class UpdateCreditApplicationConditionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationCondition::class;
}
