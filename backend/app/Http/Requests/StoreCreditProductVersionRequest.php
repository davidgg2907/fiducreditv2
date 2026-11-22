<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductVersion;

final class StoreCreditProductVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductVersion::class;
}
