<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditAmortizationInstallment;

final class UpdateCreditAmortizationInstallmentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationInstallment::class;
}
