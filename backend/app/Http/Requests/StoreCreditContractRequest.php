<?php

namespace App\Http\Requests;

use App\Models\CreditContract;

final class StoreCreditContractRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditContract::class;
}
