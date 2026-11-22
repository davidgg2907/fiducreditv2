<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowVersion;

final class UpdateCreditWorkflowVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowVersion::class;
}
