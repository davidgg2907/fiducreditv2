<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditWorkflowSla;

final class StoreCreditWorkflowSlaRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowSla::class;
}
