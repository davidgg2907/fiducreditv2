<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditCustomField;

final class StoreCreditCustomFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCustomField::class;
}
