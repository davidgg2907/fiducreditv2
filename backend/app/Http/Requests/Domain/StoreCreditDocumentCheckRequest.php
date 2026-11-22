<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDocumentCheck;

final class StoreCreditDocumentCheckRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentCheck::class;
}
