<?php

namespace App\Http\Requests;

use App\Models\CreditPayment;

final class UpdateCreditPaymentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPayment::class;
}
