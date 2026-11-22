<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditAmortizationInstallment;

final class StoreCreditAmortizationInstallmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationInstallment::class;
}
