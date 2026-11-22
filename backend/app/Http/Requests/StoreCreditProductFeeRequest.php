<?php

namespace App\Http\Requests;

use App\Models\CreditProductFee;

final class StoreCreditProductFeeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductFee::class;
}
