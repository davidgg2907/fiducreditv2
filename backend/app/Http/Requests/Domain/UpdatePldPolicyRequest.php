<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldPolicy;

final class UpdatePldPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldPolicy::class;
}
