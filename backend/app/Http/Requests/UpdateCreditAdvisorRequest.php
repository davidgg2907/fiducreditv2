<?php

namespace App\Http\Requests;

use App\Models\CreditAdvisor;

final class UpdateCreditAdvisorRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAdvisor::class;
}
