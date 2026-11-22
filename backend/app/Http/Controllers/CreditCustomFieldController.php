<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditCustomFieldRequest;
use App\Http\Requests\UpdateCreditCustomFieldRequest;
use App\Http\Resources\CreditCustomFieldResource;
use App\Models\CreditCustomField;

final class CreditCustomFieldController extends DomainResourceController
{
    protected string $modelClass = CreditCustomField::class;

    protected string $resourceClass = CreditCustomFieldResource::class;

    protected string $storeRequestClass = StoreCreditCustomFieldRequest::class;

    protected string $updateRequestClass = UpdateCreditCustomFieldRequest::class;

    protected bool $allowDirectWrites = true;
}
