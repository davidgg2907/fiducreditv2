<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanTermRequest;
use App\Http\Requests\Domain\UpdateCreditLoanTermRequest;
use App\Http\Resources\Domain\CreditLoanTermResource;
use App\Models\Domain\CreditLoanTerm;

final class CreditLoanTermController extends DomainResourceController
{
    protected string $modelClass = CreditLoanTerm::class;

    protected string $resourceClass = CreditLoanTermResource::class;

    protected string $storeRequestClass = StoreCreditLoanTermRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanTermRequest::class;

    protected bool $allowDirectWrites = false;
}
