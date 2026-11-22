<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductVersion;

final class UpdateCreditProductVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductVersion::class;
}
