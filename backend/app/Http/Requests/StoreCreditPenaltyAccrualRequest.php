<?php

namespace App\Http\Requests;

use App\Models\CreditPenaltyAccrual;

final class StoreCreditPenaltyAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPenaltyAccrual::class;
}
