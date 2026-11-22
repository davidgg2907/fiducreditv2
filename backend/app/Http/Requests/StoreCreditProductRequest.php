<?php

namespace App\Http\Requests;

use App\Models\CreditProduct;

final class StoreCreditProductRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProduct::class;
}
