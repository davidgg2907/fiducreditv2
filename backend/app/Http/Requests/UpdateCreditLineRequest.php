<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLine;

final class UpdateCreditLineRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLine::class;
}
