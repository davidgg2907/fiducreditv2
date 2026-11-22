<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditBranchRequest;
use App\Http\Requests\Domain\UpdateCreditBranchRequest;
use App\Http\Resources\Domain\CreditBranchResource;
use App\Models\Domain\CreditBranch;

final class CreditBranchController extends DomainResourceController
{
    protected string $modelClass = CreditBranch::class;

    protected string $resourceClass = CreditBranchResource::class;

    protected string $storeRequestClass = StoreCreditBranchRequest::class;

    protected string $updateRequestClass = UpdateCreditBranchRequest::class;

    protected bool $allowDirectWrites = true;
}
