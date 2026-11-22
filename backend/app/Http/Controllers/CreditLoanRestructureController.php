<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanRestructureRequest;
use App\Http\Requests\UpdateCreditLoanRestructureRequest;
use App\Http\Resources\CreditLoanRestructureResource;
use App\Models\CreditLoanRestructure;

final class CreditLoanRestructureController extends DomainResourceController
{
    protected string $modelClass = CreditLoanRestructure::class;

    protected string $resourceClass = CreditLoanRestructureResource::class;

    protected string $storeRequestClass = StoreCreditLoanRestructureRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanRestructureRequest::class;

    protected bool $allowDirectWrites = false;
}
