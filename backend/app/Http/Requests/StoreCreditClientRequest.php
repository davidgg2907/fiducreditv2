<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditClient;

final class StoreCreditClientRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClient::class;
}
