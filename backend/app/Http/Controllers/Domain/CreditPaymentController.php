<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditPaymentRequest;
use App\Http\Requests\Domain\UpdateCreditPaymentRequest;
use App\Http\Resources\Domain\CreditPaymentResource;
use App\Models\Domain\CreditPayment;

final class CreditPaymentController extends DomainResourceController
{
    protected string $modelClass = CreditPayment::class;

    protected string $resourceClass = CreditPaymentResource::class;

    protected string $storeRequestClass = StoreCreditPaymentRequest::class;

    protected string $updateRequestClass = UpdateCreditPaymentRequest::class;

    protected bool $allowDirectWrites = false;
}
