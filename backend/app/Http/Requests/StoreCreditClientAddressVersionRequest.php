<?php

namespace App\Http\Requests;

use App\Models\CreditClientAddressVersion;

final class StoreCreditClientAddressVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddressVersion::class;
}
