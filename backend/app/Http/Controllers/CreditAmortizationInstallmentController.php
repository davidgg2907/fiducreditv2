<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditAmortizationInstallmentRequest;
use App\Http\Requests\UpdateCreditAmortizationInstallmentRequest;
use App\Http\Resources\CreditAmortizationInstallmentResource;
use App\Models\CreditAmortizationInstallment;

final class CreditAmortizationInstallmentController extends DomainResourceController
{
    protected string $modelClass = CreditAmortizationInstallment::class;

    protected string $resourceClass = CreditAmortizationInstallmentResource::class;

    protected string $storeRequestClass = StoreCreditAmortizationInstallmentRequest::class;

    protected string $updateRequestClass = UpdateCreditAmortizationInstallmentRequest::class;

    protected bool $allowDirectWrites = false;
}
