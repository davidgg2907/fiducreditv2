<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditSettlementRequest;
use App\Http\Requests\UpdateCreditSettlementRequest;
use App\Http\Resources\CreditSettlementResource;
use App\Models\CreditSettlement;

final class CreditSettlementController extends DomainResourceController
{
    protected string $modelClass = CreditSettlement::class;

    protected string $resourceClass = CreditSettlementResource::class;

    protected string $storeRequestClass = StoreCreditSettlementRequest::class;

    protected string $updateRequestClass = UpdateCreditSettlementRequest::class;

    protected bool $allowDirectWrites = false;
}
