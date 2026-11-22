<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLineRequest;
use App\Http\Requests\UpdateCreditLineRequest;
use App\Http\Resources\CreditLineResource;
use App\Models\CreditLine;

final class CreditLineController extends DomainResourceController
{
    protected string $modelClass = CreditLine::class;

    protected string $resourceClass = CreditLineResource::class;

    protected string $storeRequestClass = StoreCreditLineRequest::class;

    protected string $updateRequestClass = UpdateCreditLineRequest::class;

    protected bool $allowDirectWrites = false;
}
