<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationCondition;

final class StoreCreditApplicationConditionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationCondition::class;
}
