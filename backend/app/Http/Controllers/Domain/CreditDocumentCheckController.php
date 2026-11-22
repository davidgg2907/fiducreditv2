<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditDocumentCheckRequest;
use App\Http\Requests\Domain\UpdateCreditDocumentCheckRequest;
use App\Http\Resources\Domain\CreditDocumentCheckResource;
use App\Models\Domain\CreditDocumentCheck;

final class CreditDocumentCheckController extends DomainResourceController
{
    protected string $modelClass = CreditDocumentCheck::class;

    protected string $resourceClass = CreditDocumentCheckResource::class;

    protected string $storeRequestClass = StoreCreditDocumentCheckRequest::class;

    protected string $updateRequestClass = UpdateCreditDocumentCheckRequest::class;

    protected bool $allowDirectWrites = false;
}
