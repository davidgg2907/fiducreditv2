<?php

namespace App\Http\Requests;

use App\Models\CreditLine;

final class UpdateCreditLineRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLine::class;
}
