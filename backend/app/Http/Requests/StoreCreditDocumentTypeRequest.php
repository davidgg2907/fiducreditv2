<?php

namespace App\Http\Requests;

use App\Models\CreditDocumentType;

final class StoreCreditDocumentTypeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentType::class;
}
