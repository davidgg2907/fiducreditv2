<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProductFee;

final class UpdateCreditProductFeeRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProductFee::class;
}
