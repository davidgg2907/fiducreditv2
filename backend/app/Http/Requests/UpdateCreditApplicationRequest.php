<?php

namespace App\Http\Requests;

use App\Models\CreditApplication;

final class UpdateCreditApplicationRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditApplication::class;
}
