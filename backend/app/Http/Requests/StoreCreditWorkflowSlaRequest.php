<?php

namespace App\Http\Requests;

use App\Models\CreditWorkflowSla;

final class StoreCreditWorkflowSlaRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditWorkflowSla::class;
}
