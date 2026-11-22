<?php

namespace App\Http\Requests;

use App\Models\CreditBusinessHoliday;

final class StoreCreditBusinessHolidayRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBusinessHoliday::class;
}
