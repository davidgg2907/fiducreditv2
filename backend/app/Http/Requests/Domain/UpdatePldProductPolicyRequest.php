<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldProductPolicy;

final class UpdatePldProductPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldProductPolicy::class;
}
