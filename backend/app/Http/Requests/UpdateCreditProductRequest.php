<?php

namespace App\Http\Requests;

use App\Models\CreditProduct;

final class UpdateCreditProductRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProduct::class;
}
