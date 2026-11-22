<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditAmortizationScheduleRequest;
use App\Http\Requests\UpdateCreditAmortizationScheduleRequest;
use App\Http\Resources\CreditAmortizationScheduleResource;
use App\Models\CreditAmortizationSchedule;

final class CreditAmortizationScheduleController extends DomainResourceController
{
    protected string $modelClass = CreditAmortizationSchedule::class;

    protected string $resourceClass = CreditAmortizationScheduleResource::class;

    protected string $storeRequestClass = StoreCreditAmortizationScheduleRequest::class;

    protected string $updateRequestClass = UpdateCreditAmortizationScheduleRequest::class;

    protected bool $allowDirectWrites = false;
}
