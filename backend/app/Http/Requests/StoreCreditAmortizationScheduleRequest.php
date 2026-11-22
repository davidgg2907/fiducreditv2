<?php

namespace App\Http\Requests;

use App\Models\CreditAmortizationSchedule;

final class StoreCreditAmortizationScheduleRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditAmortizationSchedule::class;
}
