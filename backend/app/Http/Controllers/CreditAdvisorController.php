<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditAdvisorRequest;
use App\Http\Requests\UpdateCreditAdvisorRequest;
use App\Http\Resources\CreditAdvisorResource;
use App\Models\CreditAdvisor;

final class CreditAdvisorController extends DomainResourceController
{
    protected string $modelClass = CreditAdvisor::class;

    protected string $resourceClass = CreditAdvisorResource::class;

    protected string $storeRequestClass = StoreCreditAdvisorRequest::class;

    protected string $updateRequestClass = UpdateCreditAdvisorRequest::class;

    protected bool $allowDirectWrites = true;
}
