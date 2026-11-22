<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanRequest;
use App\Http\Requests\Domain\UpdateCreditLoanRequest;
use App\Http\Resources\Domain\CreditLoanResource;
use App\Models\Domain\CreditLoan;

final class CreditLoanController extends DomainResourceController
{
    protected string $modelClass = CreditLoan::class;

    protected string $resourceClass = CreditLoanResource::class;

    protected string $storeRequestClass = StoreCreditLoanRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanRequest::class;

    protected bool $allowDirectWrites = false;
}
