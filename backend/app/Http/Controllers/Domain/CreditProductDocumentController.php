<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditProductDocumentRequest;
use App\Http\Requests\Domain\UpdateCreditProductDocumentRequest;
use App\Http\Resources\Domain\CreditProductDocumentResource;
use App\Models\Domain\CreditProductDocument;

final class CreditProductDocumentController extends DomainResourceController
{
    protected string $modelClass = CreditProductDocument::class;

    protected string $resourceClass = CreditProductDocumentResource::class;

    protected string $storeRequestClass = StoreCreditProductDocumentRequest::class;

    protected string $updateRequestClass = UpdateCreditProductDocumentRequest::class;

    protected bool $allowDirectWrites = true;
}
