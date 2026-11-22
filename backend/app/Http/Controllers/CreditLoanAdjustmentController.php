<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanAdjustmentRequest;
use App\Http\Requests\UpdateCreditLoanAdjustmentRequest;
use App\Http\Resources\CreditLoanAdjustmentResource;
use App\Models\CreditLoanAdjustment;

final class CreditLoanAdjustmentController extends DomainResourceController
{
    protected string $modelClass = CreditLoanAdjustment::class;

    protected string $resourceClass = CreditLoanAdjustmentResource::class;

    protected string $storeRequestClass = StoreCreditLoanAdjustmentRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanAdjustmentRequest::class;

    protected bool $allowDirectWrites = false;
}
