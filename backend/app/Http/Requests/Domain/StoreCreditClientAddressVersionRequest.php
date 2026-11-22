<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditClientAddressVersion;

final class StoreCreditClientAddressVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddressVersion::class;
}
