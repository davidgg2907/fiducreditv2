<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditClientAddressVersionRequest;
use App\Http\Requests\UpdateCreditClientAddressVersionRequest;
use App\Http\Resources\CreditClientAddressVersionResource;
use App\Models\CreditClientAddressVersion;

final class CreditClientAddressVersionController extends DomainResourceController
{
    protected string $modelClass = CreditClientAddressVersion::class;

    protected string $resourceClass = CreditClientAddressVersionResource::class;

    protected string $storeRequestClass = StoreCreditClientAddressVersionRequest::class;

    protected string $updateRequestClass = UpdateCreditClientAddressVersionRequest::class;

    protected bool $allowDirectWrites = true;
}
