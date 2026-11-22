<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditSettlement;

final class StoreCreditSettlementRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditSettlement::class;
}
