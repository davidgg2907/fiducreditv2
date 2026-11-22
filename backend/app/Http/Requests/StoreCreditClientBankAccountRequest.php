<?php

namespace App\Http\Requests;

use App\Models\CreditClientBankAccount;

final class StoreCreditClientBankAccountRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientBankAccount::class;
}
