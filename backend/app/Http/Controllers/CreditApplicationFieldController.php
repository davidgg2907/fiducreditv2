<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationFieldRequest;
use App\Http\Requests\UpdateCreditApplicationFieldRequest;
use App\Http\Resources\CreditApplicationFieldResource;
use App\Models\CreditApplicationField;

final class CreditApplicationFieldController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationField::class;

    protected string $resourceClass = CreditApplicationFieldResource::class;

    protected string $storeRequestClass = StoreCreditApplicationFieldRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationFieldRequest::class;

    protected bool $allowDirectWrites = true;
}
