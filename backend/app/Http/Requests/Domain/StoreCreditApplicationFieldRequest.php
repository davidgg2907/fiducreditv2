<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationField;

final class StoreCreditApplicationFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationField::class;
}
