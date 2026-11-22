<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditContractRequest;
use App\Http\Requests\Domain\UpdateCreditContractRequest;
use App\Http\Resources\Domain\CreditContractResource;
use App\Models\Domain\CreditContract;

final class CreditContractController extends DomainResourceController
{
    protected string $modelClass = CreditContract::class;

    protected string $resourceClass = CreditContractResource::class;

    protected string $storeRequestClass = StoreCreditContractRequest::class;

    protected string $updateRequestClass = UpdateCreditContractRequest::class;

    protected bool $allowDirectWrites = false;
}
