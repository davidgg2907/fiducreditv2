<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationStatusHistory;

final class StoreCreditApplicationStatusHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationStatusHistory::class;
}
