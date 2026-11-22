<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationStatusHistory;

final class StoreCreditApplicationStatusHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationStatusHistory::class;
}
