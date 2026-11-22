<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLinePolicyRequest;
use App\Http\Requests\Domain\UpdateCreditLinePolicyRequest;
use App\Http\Resources\Domain\CreditLinePolicyResource;
use App\Models\Domain\CreditLinePolicy;

final class CreditLinePolicyController extends DomainResourceController
{
    protected string $modelClass = CreditLinePolicy::class;

    protected string $resourceClass = CreditLinePolicyResource::class;

    protected string $storeRequestClass = StoreCreditLinePolicyRequest::class;

    protected string $updateRequestClass = UpdateCreditLinePolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
