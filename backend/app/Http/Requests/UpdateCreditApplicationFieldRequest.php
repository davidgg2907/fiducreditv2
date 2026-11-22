<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationField;

final class UpdateCreditApplicationFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationField::class;
}
