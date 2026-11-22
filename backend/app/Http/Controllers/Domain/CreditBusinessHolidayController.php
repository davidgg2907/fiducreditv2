<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditBusinessHolidayRequest;
use App\Http\Requests\Domain\UpdateCreditBusinessHolidayRequest;
use App\Http\Resources\Domain\CreditBusinessHolidayResource;
use App\Models\Domain\CreditBusinessHoliday;

final class CreditBusinessHolidayController extends DomainResourceController
{
    protected string $modelClass = CreditBusinessHoliday::class;

    protected string $resourceClass = CreditBusinessHolidayResource::class;

    protected string $storeRequestClass = StoreCreditBusinessHolidayRequest::class;

    protected string $updateRequestClass = UpdateCreditBusinessHolidayRequest::class;

    protected bool $allowDirectWrites = true;
}
