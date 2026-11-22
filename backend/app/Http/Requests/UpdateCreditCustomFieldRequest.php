<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditCustomField;

final class UpdateCreditCustomFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCustomField::class;
}
