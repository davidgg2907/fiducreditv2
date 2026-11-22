<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditPenaltyAccrual;

final class UpdateCreditPenaltyAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditPenaltyAccrual::class;
}
