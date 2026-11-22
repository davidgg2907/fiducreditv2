<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditAmortizationSchedule;

final class StoreCreditAmortizationScheduleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationSchedule::class;
}
