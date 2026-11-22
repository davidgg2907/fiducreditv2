<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductFieldRequest;
use App\Http\Requests\UpdateCreditProductFieldRequest;
use App\Http\Resources\CreditProductFieldResource;
use App\Models\CreditProductField;

final class CreditProductFieldController extends DomainResourceController
{
    protected string $modelClass = CreditProductField::class;

    protected string $resourceClass = CreditProductFieldResource::class;

    protected string $storeRequestClass = StoreCreditProductFieldRequest::class;

    protected string $updateRequestClass = UpdateCreditProductFieldRequest::class;

    protected bool $allowDirectWrites = true;
}
