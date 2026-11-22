<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditAdvisor;

final class UpdateCreditAdvisorRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAdvisor::class;
}
