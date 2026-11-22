<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditBranch;

final class StoreCreditBranchRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBranch::class;
}
