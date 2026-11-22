<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLineRequest;
use App\Http\Requests\Domain\UpdateCreditLineRequest;
use App\Http\Resources\Domain\CreditLineResource;
use App\Models\Domain\CreditLine;

final class CreditLineController extends DomainResourceController
{
    protected string $modelClass = CreditLine::class;

    protected string $resourceClass = CreditLineResource::class;

    protected string $storeRequestClass = StoreCreditLineRequest::class;

    protected string $updateRequestClass = UpdateCreditLineRequest::class;

    protected bool $allowDirectWrites = false;
}
