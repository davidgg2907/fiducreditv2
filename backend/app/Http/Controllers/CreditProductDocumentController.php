<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditProductDocumentRequest;
use App\Http\Requests\UpdateCreditProductDocumentRequest;
use App\Http\Resources\CreditProductDocumentResource;
use App\Models\CreditProductDocument;

final class CreditProductDocumentController extends DomainResourceController
{
    protected string $modelClass = CreditProductDocument::class;

    protected string $resourceClass = CreditProductDocumentResource::class;

    protected string $storeRequestClass = StoreCreditProductDocumentRequest::class;

    protected string $updateRequestClass = UpdateCreditProductDocumentRequest::class;

    protected bool $allowDirectWrites = true;
}
