<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductFieldRequest;
use App\Http\Requests\Domain\UpdateCreditProductFieldRequest;
use App\Http\Resources\Domain\CreditProductFieldResource;
use App\Models\Domain\CreditProductField;

final class CreditProductFieldController extends DomainResourceController
{
    protected string $modelClass = CreditProductField::class;

    protected string $resourceClass = CreditProductFieldResource::class;

    protected string $storeRequestClass = StoreCreditProductFieldRequest::class;

    protected string $updateRequestClass = UpdateCreditProductFieldRequest::class;

    protected bool $allowDirectWrites = true;
}
