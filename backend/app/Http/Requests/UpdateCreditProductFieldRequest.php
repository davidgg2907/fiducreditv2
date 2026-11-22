<?php

namespace App\Http\Requests;

use App\Models\CreditProductField;

final class UpdateCreditProductFieldRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductField::class;
}
