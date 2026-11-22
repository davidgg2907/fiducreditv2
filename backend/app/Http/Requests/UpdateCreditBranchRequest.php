<?php

namespace App\Http\Requests;

use App\Models\CreditBranch;

final class UpdateCreditBranchRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBranch::class;
}
