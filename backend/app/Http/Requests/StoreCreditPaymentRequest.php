<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPayment;

final class StoreCreditPaymentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayment::class;
}
