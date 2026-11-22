<?php

namespace App\Http\Requests;

use App\Models\CreditDelinquencySnapshot;

final class UpdateCreditDelinquencySnapshotRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditDelinquencySnapshot::class;
}
