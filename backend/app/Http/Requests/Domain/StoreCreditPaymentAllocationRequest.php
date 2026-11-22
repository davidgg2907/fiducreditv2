<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentAllocation;

final class StoreCreditPaymentAllocationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentAllocation::class;
}
