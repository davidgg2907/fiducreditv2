<?php

namespace App\Http\Requests;

use App\Models\CreditClientAddress;

final class UpdateCreditClientAddressRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientAddress::class;
}
