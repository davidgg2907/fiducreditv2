<?php

namespace App\Http\Requests;

use App\Models\CreditClient;

final class StoreCreditClientRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClient::class;
}
