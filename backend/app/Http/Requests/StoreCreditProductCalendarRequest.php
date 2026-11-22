<?php

namespace App\Http\Requests;

use App\Models\CreditProductCalendar;

final class StoreCreditProductCalendarRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductCalendar::class;
}
