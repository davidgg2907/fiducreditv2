<?php

namespace App\Http\Requests;

use App\Models\CreditDrawdown;

final class UpdateCreditDrawdownRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDrawdown::class;
}
