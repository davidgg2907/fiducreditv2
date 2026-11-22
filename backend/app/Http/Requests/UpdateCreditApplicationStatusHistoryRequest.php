<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationStatusHistory;

final class UpdateCreditApplicationStatusHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationStatusHistory::class;
}
