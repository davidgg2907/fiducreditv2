<?php

namespace App\Http\Requests;

use App\Models\CreditApplicationAnalyse;

final class StoreCreditApplicationAnalyseRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplicationAnalyse::class;
}
