<?php

namespace App\Http\Requests;

use App\Models\CreditProductField;

final class StoreCreditProductFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductField::class;
}
