<?php

namespace App\Http\Requests;

use App\Models\CreditAmortizationInstallment;

final class StoreCreditAmortizationInstallmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationInstallment::class;
}
