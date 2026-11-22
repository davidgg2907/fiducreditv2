<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditBusinessCalendarRequest;
use App\Http\Requests\Domain\UpdateCreditBusinessCalendarRequest;
use App\Http\Resources\Domain\CreditBusinessCalendarResource;
use App\Models\Domain\CreditBusinessCalendar;

final class CreditBusinessCalendarController extends DomainResourceController
{
    protected string $modelClass = CreditBusinessCalendar::class;

    protected string $resourceClass = CreditBusinessCalendarResource::class;

    protected string $storeRequestClass = StoreCreditBusinessCalendarRequest::class;

    protected string $updateRequestClass = UpdateCreditBusinessCalendarRequest::class;

    protected bool $allowDirectWrites = true;
}
