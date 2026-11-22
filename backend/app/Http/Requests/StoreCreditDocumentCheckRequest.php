<?php

namespace App\Http\Requests;

use App\Models\CreditDocumentCheck;

final class StoreCreditDocumentCheckRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentCheck::class;
}
