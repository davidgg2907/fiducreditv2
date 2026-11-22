<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanRateRevisionRequest;
use App\Http\Requests\UpdateCreditLoanRateRevisionRequest;
use App\Http\Resources\CreditLoanRateRevisionResource;
use App\Models\CreditLoanRateRevision;

final class CreditLoanRateRevisionController extends DomainResourceController
{
    protected string $modelClass = CreditLoanRateRevision::class;

    protected string $resourceClass = CreditLoanRateRevisionResource::class;

    protected string $storeRequestClass = StoreCreditLoanRateRevisionRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanRateRevisionRequest::class;

    protected bool $allowDirectWrites = false;
}
