<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\PldPolicyVersion;

final class StorePldPolicyVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = PldPolicyVersion::class;
}
