<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditClientAddressRequest;
use App\Http\Requests\Domain\UpdateCreditClientAddressRequest;
use App\Http\Resources\Domain\CreditClientAddressResource;
use App\Models\Domain\CreditClientAddress;

final class CreditClientAddressController extends DomainResourceController
{
    protected string $modelClass = CreditClientAddress::class;

    protected string $resourceClass = CreditClientAddressResource::class;

    protected string $storeRequestClass = StoreCreditClientAddressRequest::class;

    protected string $updateRequestClass = UpdateCreditClientAddressRequest::class;

    protected bool $allowDirectWrites = true;
}
