<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentAllocation;

final class StoreCreditPaymentAllocationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentAllocation::class;
}
