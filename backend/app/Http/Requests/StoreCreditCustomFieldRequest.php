<?php

namespace App\Http\Requests;

use App\Models\CreditCustomField;

final class StoreCreditCustomFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCustomField::class;
}
