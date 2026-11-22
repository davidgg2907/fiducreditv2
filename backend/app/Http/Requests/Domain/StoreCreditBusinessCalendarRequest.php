<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditBusinessCalendar;

final class StoreCreditBusinessCalendarRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBusinessCalendar::class;
}
