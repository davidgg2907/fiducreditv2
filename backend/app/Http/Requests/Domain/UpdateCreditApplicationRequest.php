<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplication;

final class UpdateCreditApplicationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplication::class;
}
