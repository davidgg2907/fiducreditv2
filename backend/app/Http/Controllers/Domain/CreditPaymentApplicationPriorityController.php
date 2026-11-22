<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPaymentApplicationPriorityRequest;
use App\Http\Requests\Domain\UpdateCreditPaymentApplicationPriorityRequest;
use App\Http\Resources\Domain\CreditPaymentApplicationPriorityResource;
use App\Models\Domain\CreditPaymentApplicationPriority;

final class CreditPaymentApplicationPriorityController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentApplicationPriority::class;

    protected string $resourceClass = CreditPaymentApplicationPriorityResource::class;

    protected string $storeRequestClass = StoreCreditPaymentApplicationPriorityRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentApplicationPriorityRequest::class;

    protected bool $allowDirectWrites = true;
}
