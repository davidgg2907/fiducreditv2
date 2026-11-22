<?php

namespace App\Http\Requests;

use App\Models\CreditSettlement;

final class UpdateCreditSettlementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditSettlement::class;
}
