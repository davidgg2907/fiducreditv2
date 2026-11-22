<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPaymentAllocationRequest;
use App\Http\Requests\Domain\UpdateCreditPaymentAllocationRequest;
use App\Http\Resources\Domain\CreditPaymentAllocationResource;
use App\Models\Domain\CreditPaymentAllocation;

final class CreditPaymentAllocationController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentAllocation::class;

    protected string $resourceClass = CreditPaymentAllocationResource::class;

    protected string $storeRequestClass = StoreCreditPaymentAllocationRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentAllocationRequest::class;

    protected bool $allowDirectWrites = false;
}
