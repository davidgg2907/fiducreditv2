<?php

namespace App\Http\Requests;

use App\Models\PldPolicyVersion;

final class UpdatePldPolicyVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = PldPolicyVersion::class;
}
