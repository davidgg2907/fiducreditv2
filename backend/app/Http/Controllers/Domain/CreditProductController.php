<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductRequest;
use App\Http\Requests\Domain\UpdateCreditProductRequest;
use App\Http\Resources\Domain\CreditProductResource;
use App\Models\Domain\CreditProduct;

final class CreditProductController extends DomainResourceController
{
    protected string $modelClass = CreditProduct::class;

    protected string $resourceClass = CreditProductResource::class;

    protected string $storeRequestClass = StoreCreditProductRequest::class;

    protected string $updateRequestClass = UpdateCreditProductRequest::class;

    protected bool $allowDirectWrites = true;
}
