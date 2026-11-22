<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductCalendarRequest;
use App\Http\Requests\Domain\UpdateCreditProductCalendarRequest;
use App\Http\Resources\Domain\CreditProductCalendarResource;
use App\Models\Domain\CreditProductCalendar;

final class CreditProductCalendarController extends DomainResourceController
{
    protected string $modelClass = CreditProductCalendar::class;

    protected string $resourceClass = CreditProductCalendarResource::class;

    protected string $storeRequestClass = StoreCreditProductCalendarRequest::class;

    protected string $updateRequestClass = UpdateCreditProductCalendarRequest::class;

    protected bool $allowDirectWrites = true;
}
