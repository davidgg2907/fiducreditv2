<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationRequest;
use App\Http\Requests\UpdateCreditApplicationRequest;
use App\Http\Resources\CreditApplicationResource;
use App\Models\CreditApplication;

final class CreditApplicationController extends DomainResourceController
{
    protected string $modelClass = CreditApplication::class;

    protected string $resourceClass = CreditApplicationResource::class;

    protected string $storeRequestClass = StoreCreditApplicationRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationRequest::class;

    protected bool $allowDirectWrites = true;
}
