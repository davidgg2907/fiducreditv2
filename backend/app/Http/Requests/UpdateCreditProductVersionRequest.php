<?php

namespace App\Http\Requests;

use App\Models\CreditProductVersion;

final class UpdateCreditProductVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductVersion::class;
}
