<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDelinquencySnapshot;

final class UpdateCreditDelinquencySnapshotRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDelinquencySnapshot::class;
}
