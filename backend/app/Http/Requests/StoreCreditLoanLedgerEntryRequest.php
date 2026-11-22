<?php

namespace App\Http\Requests;

use App\Models\CreditLoanLedgerEntry;

final class StoreCreditLoanLedgerEntryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanLedgerEntry::class;
}
