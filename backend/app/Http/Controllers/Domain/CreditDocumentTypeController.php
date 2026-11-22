<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditDocumentTypeRequest;
use App\Http\Requests\Domain\UpdateCreditDocumentTypeRequest;
use App\Http\Resources\Domain\CreditDocumentTypeResource;
use App\Models\Domain\CreditDocumentType;

final class CreditDocumentTypeController extends DomainResourceController
{
    protected string $modelClass = CreditDocumentType::class;

    protected string $resourceClass = CreditDocumentTypeResource::class;

    protected string $storeRequestClass = StoreCreditDocumentTypeRequest::class;

    protected string $updateRequestClass = UpdateCreditDocumentTypeRequest::class;

    protected bool $allowDirectWrites = true;
}
