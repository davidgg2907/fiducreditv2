<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditBusinessHoliday;

final class UpdateCreditBusinessHolidayRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBusinessHoliday::class;
}
