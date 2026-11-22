<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationAnalyse;

final class UpdateCreditApplicationAnalyseRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationAnalyse::class;
}
