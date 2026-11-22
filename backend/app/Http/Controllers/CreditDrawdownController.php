<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditDrawdownRequest;
use App\Http\Requests\UpdateCreditDrawdownRequest;
use App\Http\Resources\CreditDrawdownResource;
use App\Models\CreditDrawdown;

final class CreditDrawdownController extends DomainResourceController
{
    protected string $modelClass = CreditDrawdown::class;

    protected string $resourceClass = CreditDrawdownResource::class;

    protected string $storeRequestClass = StoreCreditDrawdownRequest::class;

    protected string $updateRequestClass = UpdateCreditDrawdownRequest::class;

    protected bool $allowDirectWrites = false;
}
