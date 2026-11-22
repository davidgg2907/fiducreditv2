<?php

namespace App\Http\Requests;

use App\Models\CreditBusinessCalendar;

final class StoreCreditBusinessCalendarRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBusinessCalendar::class;
}
