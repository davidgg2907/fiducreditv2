<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanAdjustmentRequest;
use App\Http\Requests\Domain\UpdateCreditLoanAdjustmentRequest;
use App\Http\Resources\Domain\CreditLoanAdjustmentResource;
use App\Models\Domain\CreditLoanAdjustment;

final class CreditLoanAdjustmentController extends DomainResourceController
{
    protected string $modelClass = CreditLoanAdjustment::class;

    protected string $resourceClass = CreditLoanAdjustmentResource::class;

    protected string $storeRequestClass = StoreCreditLoanAdjustmentRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanAdjustmentRequest::class;

    protected bool $allowDirectWrites = false;
}
