<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductRequest;
use App\Http\Requests\UpdateCreditProductRequest;
use App\Http\Resources\CreditProductResource;
use App\Models\CreditProduct;

final class CreditProductController extends DomainResourceController
{
    protected string $modelClass = CreditProduct::class;

    protected string $resourceClass = CreditProductResource::class;

    protected string $storeRequestClass = StoreCreditProductRequest::class;

    protected string $updateRequestClass = UpdateCreditProductRequest::class;

    protected bool $allowDirectWrites = true;
}
