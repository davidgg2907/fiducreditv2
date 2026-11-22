<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowSla;

final class UpdateCreditWorkflowSlaRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowSla::class;
}
