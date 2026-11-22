<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditClientAddressVersionRequest;
use App\Http\Requests\Domain\UpdateCreditClientAddressVersionRequest;
use App\Http\Resources\Domain\CreditClientAddressVersionResource;
use App\Models\Domain\CreditClientAddressVersion;

final class CreditClientAddressVersionController extends DomainResourceController
{
    protected string $modelClass = CreditClientAddressVersion::class;

    protected string $resourceClass = CreditClientAddressVersionResource::class;

    protected string $storeRequestClass = StoreCreditClientAddressVersionRequest::class;

    protected string $updateRequestClass = UpdateCreditClientAddressVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
