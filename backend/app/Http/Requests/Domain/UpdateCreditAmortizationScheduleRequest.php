<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditAmortizationSchedule;

final class UpdateCreditAmortizationScheduleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationSchedule::class;
}
