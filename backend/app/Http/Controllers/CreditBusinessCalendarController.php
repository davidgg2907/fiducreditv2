<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditBusinessCalendarRequest;
use App\Http\Requests\UpdateCreditBusinessCalendarRequest;
use App\Http\Resources\CreditBusinessCalendarResource;
use App\Models\CreditBusinessCalendar;

final class CreditBusinessCalendarController extends DomainResourceController
{
    protected string $modelClass = CreditBusinessCalendar::class;

    protected string $resourceClass = CreditBusinessCalendarResource::class;

    protected string $storeRequestClass = StoreCreditBusinessCalendarRequest::class;

    protected string $updateRequestClass = UpdateCreditBusinessCalendarRequest::class;

    protected bool $allowDirectWrites = true;
}
