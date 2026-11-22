<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDrawdown;

final class UpdateCreditDrawdownRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDrawdown::class;
}
