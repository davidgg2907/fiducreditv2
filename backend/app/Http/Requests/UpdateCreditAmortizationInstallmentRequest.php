<?php

namespace App\Http\Requests;

use App\Models\CreditAmortizationInstallment;

final class UpdateCreditAmortizationInstallmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationInstallment::class;
}
