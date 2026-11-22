<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldProductPolicy;

final class StorePldProductPolicyRequest extends DomainWriteRequest
{
    protected string $modelClass = PldProductPolicy::class;
}
