<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditCompany;

final class StoreCreditCompanyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCompany::class;
}
