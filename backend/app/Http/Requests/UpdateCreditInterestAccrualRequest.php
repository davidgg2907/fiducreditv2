<?php

namespace App\Http\Requests;

use App\Models\CreditInterestAccrual;

final class UpdateCreditInterestAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditInterestAccrual::class;
}
