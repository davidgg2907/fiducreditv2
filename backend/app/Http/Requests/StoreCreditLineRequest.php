<?php

namespace App\Http\Requests;

use App\Models\CreditLine;

final class StoreCreditLineRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLine::class;
}
