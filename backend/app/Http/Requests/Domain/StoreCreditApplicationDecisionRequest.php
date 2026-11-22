<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationDecision;

final class StoreCreditApplicationDecisionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationDecision::class;
}
