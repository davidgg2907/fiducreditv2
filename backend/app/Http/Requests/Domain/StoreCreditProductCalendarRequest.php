<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductCalendar;

final class StoreCreditProductCalendarRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductCalendar::class;
}
