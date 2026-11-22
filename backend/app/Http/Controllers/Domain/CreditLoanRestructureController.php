<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanRestructureRequest;
use App\Http\Requests\Domain\UpdateCreditLoanRestructureRequest;
use App\Http\Resources\Domain\CreditLoanRestructureResource;
use App\Models\Domain\CreditLoanRestructure;

final class CreditLoanRestructureController extends DomainResourceController
{
    protected string $modelClass = CreditLoanRestructure::class;

    protected string $resourceClass = CreditLoanRestructureResource::class;

    protected string $storeRequestClass = StoreCreditLoanRestructureRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanRestructureRequest::class;

    protected bool $allowDirectWrites = false;
}
