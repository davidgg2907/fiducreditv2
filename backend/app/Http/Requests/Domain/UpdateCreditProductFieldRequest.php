<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductField;

final class UpdateCreditProductFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductField::class;
}
