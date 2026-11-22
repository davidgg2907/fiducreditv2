<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLineMovementRequest;
use App\Http\Requests\Domain\UpdateCreditLineMovementRequest;
use App\Http\Resources\Domain\CreditLineMovementResource;
use App\Models\Domain\CreditLineMovement;

final class CreditLineMovementController extends DomainResourceController
{
    protected string $modelClass = CreditLineMovement::class;

    protected string $resourceClass = CreditLineMovementResource::class;

    protected string $storeRequestClass = StoreCreditLineMovementRequest::class;

    protected string $updateRequestClass = UpdateCreditLineMovementRequest::class;

    protected bool $allowDirectWrites = false;
}
