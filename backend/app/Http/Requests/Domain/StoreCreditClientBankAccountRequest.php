<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditClientBankAccount;

final class StoreCreditClientBankAccountRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditClientBankAccount::class;
}
