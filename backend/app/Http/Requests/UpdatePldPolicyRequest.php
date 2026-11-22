<?php

namespace App\Http\Requests;

use App\Models\PldPolicy;

final class UpdatePldPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldPolicy::class;
}
