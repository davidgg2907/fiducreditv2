<?php

namespace App\Http\Requests;

use App\Models\CreditAdvisor;

final class StoreCreditAdvisorRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAdvisor::class;
}
