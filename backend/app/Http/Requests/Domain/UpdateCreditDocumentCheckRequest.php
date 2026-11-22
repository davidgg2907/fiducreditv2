<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDocumentCheck;

final class UpdateCreditDocumentCheckRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentCheck::class;
}
