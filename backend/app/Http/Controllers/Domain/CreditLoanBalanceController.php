<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanBalanceRequest;
use App\Http\Requests\Domain\UpdateCreditLoanBalanceRequest;
use App\Http\Resources\Domain\CreditLoanBalanceResource;
use App\Models\Domain\CreditLoanBalance;

final class CreditLoanBalanceController extends DomainResourceController
{
    protected string $modelClass = CreditLoanBalance::class;

    protected string $resourceClass = CreditLoanBalanceResource::class;

    protected string $storeRequestClass = StoreCreditLoanBalanceRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanBalanceRequest::class;

    protected bool $allowDirectWrites = false;
}
