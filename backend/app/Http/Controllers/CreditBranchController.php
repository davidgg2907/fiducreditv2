<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditBranchRequest;
use App\Http\Requests\UpdateCreditBranchRequest;
use App\Http\Resources\CreditBranchResource;
use App\Models\CreditBranch;

final class CreditBranchController extends DomainResourceController
{
    protected string $modelClass = CreditBranch::class;

    protected string $resourceClass = CreditBranchResource::class;

    protected string $storeRequestClass = StoreCreditBranchRequest::class;

    protected string $updateRequestClass = UpdateCreditBranchRequest::class;

    protected bool $allowDirectWrites = true;
}
