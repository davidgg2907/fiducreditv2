<?php

namespace App\Http\Requests;

use App\Models\PldPolicyVersion;

final class StorePldPolicyVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = PldPolicyVersion::class;
}
