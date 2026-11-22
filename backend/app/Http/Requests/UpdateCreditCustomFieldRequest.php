<?php

namespace App\Http\Requests;

use App\Models\CreditCustomField;

final class UpdateCreditCustomFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCustomField::class;
}
