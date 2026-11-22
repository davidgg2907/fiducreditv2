<?php

namespace App\Http\Requests;

use App\Models\CreditSettlement;

final class StoreCreditSettlementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditSettlement::class;
}
