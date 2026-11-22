<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLinePolicyRequest;
use App\Http\Requests\UpdateCreditLinePolicyRequest;
use App\Http\Resources\CreditLinePolicyResource;
use App\Models\CreditLinePolicy;

final class CreditLinePolicyController extends DomainResourceController
{
    protected string $modelClass = CreditLinePolicy::class;

    protected string $resourceClass = CreditLinePolicyResource::class;

    protected string $storeRequestClass = StoreCreditLinePolicyRequest::class;

    protected string $updateRequestClass = UpdateCreditLinePolicyRequest::class;

    protected bool $allowDirectWrites = true;
}
