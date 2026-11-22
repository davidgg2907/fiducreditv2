<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditInterestAccrualRequest;
use App\Http\Requests\UpdateCreditInterestAccrualRequest;
use App\Http\Resources\CreditInterestAccrualResource;
use App\Models\CreditInterestAccrual;

final class CreditInterestAccrualController extends DomainResourceController
{
    protected string $modelClass = CreditInterestAccrual::class;

    protected string $resourceClass = CreditInterestAccrualResource::class;

    protected string $storeRequestClass = StoreCreditInterestAccrualRequest::class;

    protected string $updateRequestClass = UpdateCreditInterestAccrualRequest::class;

    protected bool $allowDirectWrites = false;
}
