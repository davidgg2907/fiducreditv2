<?php

namespace App\Http\Requests;

use App\Models\CreditApplication;

final class StoreCreditApplicationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplication::class;
}
