<?php

namespace App\Http\Requests;

use App\Models\CreditProductVersion;

final class StoreCreditProductVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductVersion::class;
}
