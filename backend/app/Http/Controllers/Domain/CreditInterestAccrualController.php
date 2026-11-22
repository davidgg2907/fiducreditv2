<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditInterestAccrualRequest;
use App\Http\Requests\Domain\UpdateCreditInterestAccrualRequest;
use App\Http\Resources\Domain\CreditInterestAccrualResource;
use App\Models\Domain\CreditInterestAccrual;

final class CreditInterestAccrualController extends DomainResourceController
{
    protected string $modelClass = CreditInterestAccrual::class;

    protected string $resourceClass = CreditInterestAccrualResource::class;

    protected string $storeRequestClass = StoreCreditInterestAccrualRequest::class;

    protected string $updateRequestClass = UpdateCreditInterestAccrualRequest::class;

    protected bool $allowDirectWrites = false;
}
