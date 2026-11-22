<?php

namespace App\Http\Requests;

use App\Models\CreditClientAddressVersion;

final class UpdateCreditClientAddressVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddressVersion::class;
}
