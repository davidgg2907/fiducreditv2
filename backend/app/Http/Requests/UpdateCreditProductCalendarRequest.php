<?php

namespace App\Http\Requests;

use App\Models\CreditProductCalendar;

final class UpdateCreditProductCalendarRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductCalendar::class;
}
