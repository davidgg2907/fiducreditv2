<?php

namespace App\Http\Requests;

use App\Models\CreditDelinquencySnapshot;

final class StoreCreditDelinquencySnapshotRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDelinquencySnapshot::class;
}
