<?php

namespace App\Http\Requests;

use App\Models\CreditLineLimitHistory;

final class StoreCreditLineLimitHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineLimitHistory::class;
}
