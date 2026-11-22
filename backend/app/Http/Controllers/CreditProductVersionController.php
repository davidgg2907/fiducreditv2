<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductVersionRequest;
use App\Http\Requests\UpdateCreditProductVersionRequest;
use App\Http\Resources\CreditProductVersionResource;
use App\Models\CreditProductVersion;

final class CreditProductVersionController extends DomainResourceController
{
    protected string $modelClass = CreditProductVersion::class;

    protected string $resourceClass = CreditProductVersionResource::class;

    protected string $storeRequestClass = StoreCreditProductVersionRequest::class;

    protected string $updateRequestClass = UpdateCreditProductVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
