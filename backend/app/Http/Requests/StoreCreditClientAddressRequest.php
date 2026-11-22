<?php

namespace App\Http\Requests;

use App\Models\CreditClientAddress;

final class StoreCreditClientAddressRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddress::class;
}
