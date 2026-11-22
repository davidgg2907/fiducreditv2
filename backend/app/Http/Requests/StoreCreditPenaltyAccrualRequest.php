<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPenaltyAccrual;

final class StoreCreditPenaltyAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPenaltyAccrual::class;
}
