<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPaymentApplicationPriorityRequest;
use App\Http\Requests\UpdateCreditPaymentApplicationPriorityRequest;
use App\Http\Resources\CreditPaymentApplicationPriorityResource;
use App\Models\CreditPaymentApplicationPriority;

final class CreditPaymentApplicationPriorityController extends DomainResourceController
{
    protected string $modelClass = CreditPaymentApplicationPriority::class;

    protected string $resourceClass = CreditPaymentApplicationPriorityResource::class;

    protected string $storeRequestClass = StoreCreditPaymentApplicationPriorityRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentApplicationPriorityRequest::class;

    protected bool $allowDirectWrites = true;
}
