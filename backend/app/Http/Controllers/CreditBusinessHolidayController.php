<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditBusinessHolidayRequest;
use App\Http\Requests\UpdateCreditBusinessHolidayRequest;
use App\Http\Resources\CreditBusinessHolidayResource;
use App\Models\CreditBusinessHoliday;

final class CreditBusinessHolidayController extends DomainResourceController
{
    protected string $modelClass = CreditBusinessHoliday::class;

    protected string $resourceClass = CreditBusinessHolidayResource::class;

    protected string $storeRequestClass = StoreCreditBusinessHolidayRequest::class;

    protected string $updateRequestClass = UpdateCreditBusinessHolidayRequest::class;

    protected bool $allowDirectWrites = true;
}
