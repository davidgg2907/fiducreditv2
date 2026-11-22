<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanTermRequest;
use App\Http\Requests\UpdateCreditLoanTermRequest;
use App\Http\Resources\CreditLoanTermResource;
use App\Models\CreditLoanTerm;

final class CreditLoanTermController extends DomainResourceController
{
    protected string $modelClass = CreditLoanTerm::class;

    protected string $resourceClass = CreditLoanTermResource::class;

    protected string $storeRequestClass = StoreCreditLoanTermRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanTermRequest::class;

    protected bool $allowDirectWrites = false;
}
