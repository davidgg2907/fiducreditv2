<?php

namespace App\Http\Requests;

use App\Models\CreditProductDocument;

final class StoreCreditProductDocumentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductDocument::class;
}
