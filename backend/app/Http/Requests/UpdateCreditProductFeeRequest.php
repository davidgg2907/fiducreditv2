<?php

namespace App\Http\Requests;

use App\Models\CreditProductFee;

final class UpdateCreditProductFeeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductFee::class;
}
