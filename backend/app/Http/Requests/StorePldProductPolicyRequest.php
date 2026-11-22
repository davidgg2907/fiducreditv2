<?php

namespace App\Http\Requests;

use App\Models\PldProductPolicy;

final class StorePldProductPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldProductPolicy::class;
}
