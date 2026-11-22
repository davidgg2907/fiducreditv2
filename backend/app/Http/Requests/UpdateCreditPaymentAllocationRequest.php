<?php

namespace App\Http\Requests;

use App\Models\CreditPaymentAllocation;

final class UpdateCreditPaymentAllocationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentAllocation::class;
}
