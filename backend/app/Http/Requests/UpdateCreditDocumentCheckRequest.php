<?php

namespace App\Http\Requests;

use App\Models\CreditDocumentCheck;

final class UpdateCreditDocumentCheckRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDocumentCheck::class;
}
