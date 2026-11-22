<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditDocumentCheckRequest;
use App\Http\Requests\UpdateCreditDocumentCheckRequest;
use App\Http\Resources\CreditDocumentCheckResource;
use App\Models\CreditDocumentCheck;

final class CreditDocumentCheckController extends DomainResourceController
{
    protected string $modelClass = CreditDocumentCheck::class;

    protected string $resourceClass = CreditDocumentCheckResource::class;

    protected string $storeRequestClass = StoreCreditDocumentCheckRequest::class;

    protected string $updateRequestClass = UpdateCreditDocumentCheckRequest::class;

    protected bool $allowDirectWrites = false;
}
