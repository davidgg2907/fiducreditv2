<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDocumentType;

final class UpdateCreditDocumentTypeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentType::class;
}
