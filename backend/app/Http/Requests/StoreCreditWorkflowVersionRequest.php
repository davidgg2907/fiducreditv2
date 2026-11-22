<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowVersion;

final class StoreCreditWorkflowVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowVersion::class;
}
