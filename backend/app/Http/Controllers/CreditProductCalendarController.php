<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductCalendarRequest;
use App\Http\Requests\UpdateCreditProductCalendarRequest;
use App\Http\Resources\CreditProductCalendarResource;
use App\Models\CreditProductCalendar;

final class CreditProductCalendarController extends DomainResourceController
{
    protected string $modelClass = CreditProductCalendar::class;

    protected string $resourceClass = CreditProductCalendarResource::class;

    protected string $storeRequestClass = StoreCreditProductCalendarRequest::class;

    protected string $updateRequestClass = UpdateCreditProductCalendarRequest::class;

    protected bool $allowDirectWrites = true;
}
