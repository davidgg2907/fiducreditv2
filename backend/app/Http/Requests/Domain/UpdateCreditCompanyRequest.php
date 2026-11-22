<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditCompany;

final class UpdateCreditCompanyRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditCompany::class;
}
