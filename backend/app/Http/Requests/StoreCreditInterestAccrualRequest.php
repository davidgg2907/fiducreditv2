<?php

namespace App\Http\Requests;

use App\Models\CreditInterestAccrual;

final class StoreCreditInterestAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditInterestAccrual::class;
}
