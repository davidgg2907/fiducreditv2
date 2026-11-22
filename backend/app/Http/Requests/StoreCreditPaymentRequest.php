<?php

namespace App\Http\Requests;

use App\Models\CreditPayment;

final class StoreCreditPaymentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayment::class;
}
