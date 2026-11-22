<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditApplicationAnalyse;

final class StoreCreditApplicationAnalyseRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationAnalyse::class;
}
