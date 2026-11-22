<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditClientAddress;

final class StoreCreditClientAddressRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddress::class;
}
