<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditBranch;

final class UpdateCreditBranchRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditBranch::class;
}
