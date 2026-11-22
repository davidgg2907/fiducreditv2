<?php

namespace App\Http\Requests;

use App\Models\CreditContract;

final class UpdateCreditContractRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditContract::class;
}
