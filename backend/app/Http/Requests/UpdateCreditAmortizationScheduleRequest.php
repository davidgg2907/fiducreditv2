<?php

namespace App\Http\Requests;

use App\Models\CreditAmortizationSchedule;

final class UpdateCreditAmortizationScheduleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationSchedule::class;
}
