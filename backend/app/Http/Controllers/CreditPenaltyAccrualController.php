<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPenaltyAccrualRequest;
use App\Http\Requests\UpdateCreditPenaltyAccrualRequest;
use App\Http\Resources\CreditPenaltyAccrualResource;
use App\Models\CreditPenaltyAccrual;

final class CreditPenaltyAccrualController extends DomainResourceController
{
    protected string $modelClass = CreditPenaltyAccrual::class;

    protected string $resourceClass = CreditPenaltyAccrualResource::class;

    protected string $storeRequestClass = StoreCreditPenaltyAccrualRequest::class;

    protected string $updateRequestClass = UpdateCreditPenaltyAccrualRequest::class;

    protected bool $allowDirectWrites = false;
}
