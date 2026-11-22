<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductField;

final class StoreCreditProductFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductField::class;
}
