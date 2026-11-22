<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDocumentType;

final class StoreCreditDocumentTypeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentType::class;
}
