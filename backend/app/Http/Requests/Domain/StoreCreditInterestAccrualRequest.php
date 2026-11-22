<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditInterestAccrual;

final class StoreCreditInterestAccrualRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditInterestAccrual::class;
}
