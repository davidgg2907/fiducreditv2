<?php

namespace App\Http\Requests;

use App\Models\CreditBusinessHoliday;

final class UpdateCreditBusinessHolidayRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBusinessHoliday::class;
}
