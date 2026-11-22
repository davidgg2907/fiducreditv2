<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanBalanceRequest;
use App\Http\Requests\UpdateCreditLoanBalanceRequest;
use App\Http\Resources\CreditLoanBalanceResource;
use App\Models\CreditLoanBalance;

final class CreditLoanBalanceController extends DomainResourceController
{
    protected string $modelClass = CreditLoanBalance::class;

    protected string $resourceClass = CreditLoanBalanceResource::class;

    protected string $storeRequestClass = StoreCreditLoanBalanceRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanBalanceRequest::class;

    protected bool $allowDirectWrites = false;
}
