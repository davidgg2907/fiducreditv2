<?php

namespace App\Http\Requests;

use App\Models\CreditLineLimitHistory;

final class UpdateCreditLineLimitHistoryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLineLimitHistory::class;
}
