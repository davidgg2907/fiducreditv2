<?php

namespace App\Http\Requests;

use App\Models\CreditDocumentType;

final class UpdateCreditDocumentTypeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentType::class;
}
