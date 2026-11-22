<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationField;

final class StoreCreditApplicationFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationField::class;
}
