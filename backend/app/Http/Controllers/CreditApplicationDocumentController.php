<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditApplicationDocumentRequest;
use App\Http\Requests\UpdateCreditApplicationDocumentRequest;
use App\Http\Resources\CreditApplicationDocumentResource;
use App\Models\CreditApplicationDocument;

final class CreditApplicationDocumentController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationDocument::class;

    protected string $resourceClass = CreditApplicationDocumentResource::class;

    protected string $storeRequestClass = StoreCreditApplicationDocumentRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationDocumentRequest::class;

    protected bool $allowDirectWrites = true;
}
