<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditAdvisorRequest;
use App\Http\Requests\Domain\UpdateCreditAdvisorRequest;
use App\Http\Resources\Domain\CreditAdvisorResource;
use App\Models\Domain\CreditAdvisor;

final class CreditAdvisorController extends DomainResourceController
{
    protected string $modelClass = CreditAdvisor::class;

    protected string $resourceClass = CreditAdvisorResource::class;

    protected string $storeRequestClass = StoreCreditAdvisorRequest::class;

    protected string $updateRequestClass = UpdateCreditAdvisorRequest::class;

    protected bool $allowDirectWrites = true;
}
