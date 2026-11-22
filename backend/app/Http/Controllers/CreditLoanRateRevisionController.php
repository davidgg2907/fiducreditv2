<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanRateRevisionRequest;
use App\Http\Requests\Domain\UpdateCreditLoanRateRevisionRequest;
use App\Http\Resources\Domain\CreditLoanRateRevisionResource;
use App\Models\Domain\CreditLoanRateRevision;

final class CreditLoanRateRevisionController extends DomainResourceController
{
    protected string $modelClass = CreditLoanRateRevision::class;

    protected string $resourceClass = CreditLoanRateRevisionResource::class;

    protected string $storeRequestClass = StoreCreditLoanRateRevisionRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanRateRevisionRequest::class;

    protected bool $allowDirectWrites = false;
}
