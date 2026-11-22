<?php

namespace App\Http\Requests;

use App\Models\CreditBusinessCalendar;

final class UpdateCreditBusinessCalendarRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBusinessCalendar::class;
}
