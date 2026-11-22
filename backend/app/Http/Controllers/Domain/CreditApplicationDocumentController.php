<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditApplicationDocumentRequest;
use App\Http\Requests\Domain\UpdateCreditApplicationDocumentRequest;
use App\Http\Resources\Domain\CreditApplicationDocumentResource;
use App\Models\Domain\CreditApplicationDocument;

final class CreditApplicationDocumentController extends DomainResourceController
{
    protected string $modelClass = CreditApplicationDocument::class;

    protected string $resourceClass = CreditApplicationDocumentResource::class;

    protected string $storeRequestClass = StoreCreditApplicationDocumentRequest::class;

    protected string $updateRequestClass = UpdateCreditApplicationDocumentRequest::class;

    protected bool $allowDirectWrites = true;
}
