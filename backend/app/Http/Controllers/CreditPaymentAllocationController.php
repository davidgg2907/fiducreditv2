<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPaymentAllocationRequest;
use App\Http\Requests\UpdateCreditPaymentAllocationRequest;
use App\Http\Resources\CreditPaymentAllocationResource;
use App\Models\CreditPaymentAllocation;

final class CreditPaymentAllocationController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentAllocation::class;

    protected string $resourceClass = CreditPaymentAllocationResource::class;

    protected string $storeRequestClass = StoreCreditPaymentAllocationRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentAllocationRequest::class;

    protected bool $allowDirectWrites = false;
}
