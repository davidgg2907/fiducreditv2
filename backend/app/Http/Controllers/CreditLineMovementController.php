<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLineMovementRequest;
use App\Http\Requests\UpdateCreditLineMovementRequest;
use App\Http\Resources\CreditLineMovementResource;
use App\Models\CreditLineMovement;

final class CreditLineMovementController extends DomainResourceController
{
    protected string $modelClass = CreditLineMovement::class;

    protected string $resourceClass = CreditLineMovementResource::class;

    protected string $storeRequestClass = StoreCreditLineMovementRequest::class;

    protected string $updateRequestClass = UpdateCreditLineMovementRequest::class;

    protected bool $allowDirectWrites = false;
}
