<?php

namespace App\Http\Requests\Domain;

use App\Models\Domain\CreditLoanLedgerEntry;

final class StoreCreditLoanLedgerEntryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanLedgerEntry::class;
}
