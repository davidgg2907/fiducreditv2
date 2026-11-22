<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationDecision;

final class StoreCreditApplicationDecisionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationDecision::class;
}
