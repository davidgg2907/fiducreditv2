<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditDocumentTypeRequest;
use App\Http\Requests\UpdateCreditDocumentTypeRequest;
use App\Http\Resources\CreditDocumentTypeResource;
use App\Models\CreditDocumentType;

final class CreditDocumentTypeController extends DomainResourceController
{
    protected string $modelClass = CreditDocumentType::class;

    protected string $resourceClass = CreditDocumentTypeResource::class;

    protected string $storeRequestClass = StoreCreditDocumentTypeRequest::class;

    protected string $updateRequestClass = UpdateCreditDocumentTypeRequest::class;

    protected bool $allowDirectWrites = true;
}
