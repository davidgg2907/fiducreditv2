<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditClientAddressRequest;
use App\Http\Requests\UpdateCreditClientAddressRequest;
use App\Http\Resources\CreditClientAddressResource;
use App\Models\CreditClientAddress;

final class CreditClientAddressController extends DomainResourceController
{
    protected string $modelClass = CreditClientAddress::class;

    protected string $resourceClass = CreditClientAddressResource::class;

    protected string $storeRequestClass = StoreCreditClientAddressRequest::class;

    protected string $updateRequestClass = UpdateCreditClientAddressRequest::class;

    protected bool $allowDirectWrites = true;
}
