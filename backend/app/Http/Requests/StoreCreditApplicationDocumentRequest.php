<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationDocument;

final class StoreCreditApplicationDocumentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationDocument::class;
}
