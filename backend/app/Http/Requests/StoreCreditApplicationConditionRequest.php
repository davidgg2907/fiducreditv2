<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationCondition;

final class StoreCreditApplicationConditionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationCondition::class;
}
