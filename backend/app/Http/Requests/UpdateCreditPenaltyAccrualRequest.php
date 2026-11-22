<?php

namespace App\Http\Requests;

use App\Models\CreditPenaltyAccrual;

final class UpdateCreditPenaltyAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPenaltyAccrual::class;
}
