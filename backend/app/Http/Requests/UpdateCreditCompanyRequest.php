<?php

namespace App\Http\Requests;

use App\Models\CreditCompany;

final class UpdateCreditCompanyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCompany::class;
}
