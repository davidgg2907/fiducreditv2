<?php

namespace App\Http\Requests;

use App\Models\PldProductPolicy;

final class UpdatePldProductPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldProductPolicy::class;
}
