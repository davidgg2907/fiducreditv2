<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationRequest;
use App\Http\Resources\Domain\CreditApplicationResource;
use App\Models\Domain\CreditApplication;

final class CreditApplicationController extends DomainResourceController
{
    protected string $modelClass = CreditApplication::class;

    protected string $resourceClass = CreditApplicationResource::class;

    protected string $storeRequestClass = StoreCreditApplicationRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationRequest::class;

    protected bool $allowDirectWrites = true;
}
