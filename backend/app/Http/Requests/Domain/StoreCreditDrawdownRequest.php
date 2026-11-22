<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDrawdown;

final class StoreCreditDrawdownRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDrawdown::class;
}
