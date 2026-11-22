<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditDelinquencySnapshot;

final class StoreCreditDelinquencySnapshotRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDelinquencySnapshot::class;
}
