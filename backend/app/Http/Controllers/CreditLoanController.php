<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanRequest;
use App\Http\Requests\UpdateCreditLoanRequest;
use App\Http\Resources\CreditLoanResource;
use App\Models\CreditLoan;

final class CreditLoanController extends DomainResourceController
{
    protected string $modelClass = CreditLoan::class;

    protected string $resourceClass = CreditLoanResource::class;

    protected string $storeRequestClass = StoreCreditLoanRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanRequest::class;

    protected bool $allowDirectWrites = false;
}
