<?php

namespace App\Http\Requests;

use App\Models\PldPolicy;

final class StorePldPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldPolicy::class;
}
