<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationDocument;

final class UpdateCreditApplicationDocumentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationDocument::class;
}
