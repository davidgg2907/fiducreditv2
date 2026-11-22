<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationDocument;

final class UpdateCreditApplicationDocumentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationDocument::class;
}
