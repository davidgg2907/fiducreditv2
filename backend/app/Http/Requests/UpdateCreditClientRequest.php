<?php

namespace App\Http\Requests;

use App\Models\CreditClient;

final class UpdateCreditClientRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClient::class;
}
