<?php

namespace App\Http\Requests;

use App\Models\CreditCompany;

final class StoreCreditCompanyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCompany::class;
}
