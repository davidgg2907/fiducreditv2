<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditPaymentRequest;
use App\Http\Requests\UpdateCreditPaymentRequest;
use App\Http\Resources\CreditPaymentResource;
use App\Models\CreditPayment;

final class CreditPaymentController extends DomainResourceController
{
    protected string $modelClass = CreditPayment::class;

    protected string $resourceClass = CreditPaymentResource::class;

    protected string $storeRequestClass = StoreCreditPaymentRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentRequest::class;

    protected bool $allowDirectWrites = false;
}
