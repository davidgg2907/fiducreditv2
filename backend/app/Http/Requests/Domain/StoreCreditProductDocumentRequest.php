<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductDocument;

final class StoreCreditProductDocumentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductDocument::class;
}
