<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditContractRequest;
use App\Http\Requests\UpdateCreditContractRequest;
use App\Http\Resources\CreditContractResource;
use App\Models\CreditContract;

final class CreditContractController extends DomainResourceController
{
    protected string $modelClass = CreditContract::class;

    protected string $resourceClass = CreditContractResource::class;

    protected string $storeRequestClass = StoreCreditContractRequest::class;

    protected string $updateRequestClass = UpdateCreditContractRequest::class;

    protected bool $allowDirectWrites = false;
}
