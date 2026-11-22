<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLineLimitHistory;

final class StoreCreditLineLimitHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineLimitHistory::class;
}
