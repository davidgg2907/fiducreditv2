<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationDecision;

final class UpdateCreditApplicationDecisionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationDecision::class;
}
