<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditAmortizationScheduleRequest;
use App\Http\Requests\Domain\UpdateCreditAmortizationScheduleRequest;
use App\Http\Resources\Domain\CreditAmortizationScheduleResource;
use App\Models\Domain\CreditAmortizationSchedule;

final class CreditAmortizationScheduleController extends DomainResourceController
{
    protected string $modelClass = CreditAmortizationSchedule::class;

    protected string $resourceClass = CreditAmortizationScheduleResource::class;

    protected string $storeRequestClass = StoreCreditAmortizationScheduleRequest::class;

    protected string $updateRequestClass = UpdateCreditAmortizationScheduleRequest::class;

    protected bool $allowDirectWrites = false;
}
