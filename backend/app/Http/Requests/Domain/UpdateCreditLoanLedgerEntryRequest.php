<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanLedgerEntry;

final class UpdateCreditLoanLedgerEntryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanLedgerEntry::class;
}
