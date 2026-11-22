<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowVersion;

final class StoreCreditWorkflowVersionRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowVersion::class;
}
