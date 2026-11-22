<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationAnalyse;

final class UpdateCreditApplicationAnalyseRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationAnalyse::class;
}
