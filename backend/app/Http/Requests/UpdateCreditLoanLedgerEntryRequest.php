<?php

namespace App\Http\Requests;

use App\Models\CreditLoanLedgerEntry;

final class UpdateCreditLoanLedgerEntryRequest extends DomainWriteRequest
{
    protected string $modelClass = CreditLoanLedgerEntry::class;
}
