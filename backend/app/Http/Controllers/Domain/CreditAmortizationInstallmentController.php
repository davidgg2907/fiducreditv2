<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditAmortizationInstallmentRequest;
use App\Http\Requests\Domain\UpdateCreditAmortizationInstallmentRequest;
use App\Http\Resources\Domain\CreditAmortizationInstallmentResource;
use App\Models\Domain\CreditAmortizationInstallment;

final class CreditAmortizationInstallmentController extends DomainResourceController
{
    protected string $modelClass = CreditAmortizationInstallment::class;

    protected string $resourceClass = CreditAmortizationInstallmentResource::class;

    protected string $storeRequestClass = StoreCreditAmortizationInstallmentRequest::class;

    protected string $updateRequestClass = UpdateCreditAmortizationInstallmentRequest::class;

    protected bool $allowDirectWrites = false;
}
