<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditDrawdownRequest;
use App\Http\Requests\Domain\UpdateCreditDrawdownRequest;
use App\Http\Resources\Domain\CreditDrawdownResource;
use App\Models\Domain\CreditDrawdown;

final class CreditDrawdownController extends DomainResourceController
{
    protected string $modelClass = CreditDrawdown::class;

    protected string $resourceClass = CreditDrawdownResource::class;

    protected string $storeRequestClass = StoreCreditDrawdownRequest::class;

    protected string $updateRequestClass = UpdateCreditDrawdownRequest::class;

    protected bool $allowDirectWrites = false;
}
