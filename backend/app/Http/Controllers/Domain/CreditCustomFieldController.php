<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditCustomFieldRequest;
use App\Http\Requests\Domain\UpdateCreditCustomFieldRequest;
use App\Http\Resources\Domain\CreditCustomFieldResource;
use App\Models\Domain\CreditCustomField;

final class CreditCustomFieldController extends DomainResourceController
{
    protected string $modelClass = CreditCustomField::class;

    protected string $resourceClass = CreditCustomFieldResource::class;

    protected string $storeRequestClass = StoreCreditCustomFieldRequest::class;

    protected string $updateRequestClass = UpdateCreditCustomFieldRequest::class;

    protected bool $allowDirectWrites = true;
}
