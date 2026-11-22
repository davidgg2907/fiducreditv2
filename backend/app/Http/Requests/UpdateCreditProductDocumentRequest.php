<?php

namespace App\Http\Requests;

use App\Models\CreditProductDocument;

final class UpdateCreditProductDocumentRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductDocument::class;
}
