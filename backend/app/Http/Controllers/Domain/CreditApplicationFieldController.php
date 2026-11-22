<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationFieldRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationFieldRequest;
use App\Http\Resources\Domain\CreditApplicationFieldResource;
use App\Models\Domain\CreditApplicationField;

final class CreditApplicationFieldController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationField::class;

    protected string $resourceClass = CreditApplicationFieldResource::class;

    protected string $storeRequestClass = StoreCreditApplicationFieldRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationFieldRequest::class;

    protected bool $allowDirectWrites = true;
}
