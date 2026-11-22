<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditProduct;

final class UpdateCreditProductRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditProduct::class;
}
