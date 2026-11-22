<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPaymentAllocation;

final class UpdateCreditPaymentAllocationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPaymentAllocation::class;
}
