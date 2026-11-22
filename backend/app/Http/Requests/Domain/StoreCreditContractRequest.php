<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditContract;

final class StoreCreditContractRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditContract::class;
}
