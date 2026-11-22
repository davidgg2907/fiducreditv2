<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowSla;

final class UpdateCreditWorkflowSlaRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowSla::class;
}
