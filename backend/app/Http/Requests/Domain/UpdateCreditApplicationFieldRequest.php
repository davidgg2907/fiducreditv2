<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationField;

final class UpdateCreditApplicationFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationField::class;
}
