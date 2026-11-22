<?php

namespace App\Http\Requests;

use App\Models\CreditBranch;

final class StoreCreditBranchRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBranch::class;
}
