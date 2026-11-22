<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditClientAddress;

final class UpdateCreditClientAddressRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddress::class;
}
