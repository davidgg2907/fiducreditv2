<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductVersionRequest;
use App\Http\Requests\Domain\UpdateCreditProductVersionRequest;
use App\Http\Resources\Domain\CreditProductVersionResource;
use App\Models\Domain\CreditProductVersion;

final class CreditProductVersionController extends DomainResourceController
{
    protected string $modelClass = CreditProductVersion::class;

    protected string $resourceClass = CreditProductVersionResource::class;

    protected string $storeRequestClass = StoreCreditProductVersionRequest::class;

    protected string $updateRequestClass = UpdateCreditProductVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
