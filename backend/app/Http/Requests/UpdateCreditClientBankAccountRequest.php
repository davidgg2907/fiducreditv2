<?php

namespace App\Http\Requests;

use App\Models\CreditClientBankAccount;

final class UpdateCreditClientBankAccountRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientBankAccount::class;
}
