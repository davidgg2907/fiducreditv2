<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowVersion;

final class UpdateCreditWorkflowVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowVersion::class;
}
