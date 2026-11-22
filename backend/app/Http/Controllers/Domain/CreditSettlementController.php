<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditSettlementRequest;
use App\Http\Requests\Domain\UpdateCreditSettlementRequest;
use App\Http\Resources\Domain\CreditSettlementResource;
use App\Models\Domain\CreditSettlement;

final class CreditSettlementController extends DomainResourceController
{
    protected string $modelClass = CreditSettlement::class;

    protected string $resourceClass = CreditSettlementResource::class;

    protected string $storeRequestClass = StoreCreditSettlementRequest::class;

    protected string $updateRequestClass = UpdateCreditSettlementRequest::class;

    protected bool $allowDirectWrites = false;
}
