<?php

namespace App\Http\Requests;

use App\Models\CreditDrawdown;

final class StoreCreditDrawdownRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDrawdown::class;
}
