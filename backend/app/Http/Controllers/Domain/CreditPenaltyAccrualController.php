<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPenaltyAccrualRequest;
use App\Http\Requests\Domain\UpdateCreditPenaltyAccrualRequest;
use App\Http\Resources\Domain\CreditPenaltyAccrualResource;
use App\Models\Domain\CreditPenaltyAccrual;

final class CreditPenaltyAccrualController extends DomainResourceController
{
    protected string $modelClass = CreditPenaltyAccrual::class;

    protected string $resourceClass = CreditPenaltyAccrualResource::class;

    protected string $storeRequestClass = StoreCreditPenaltyAccrualRequest::class;

    protected string $updateRequestClass = UpdateCreditPenaltyAccrualRequest::class;

    protected bool $allowDirectWrites = false;
}
