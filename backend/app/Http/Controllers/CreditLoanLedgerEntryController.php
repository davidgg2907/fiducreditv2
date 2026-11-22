<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditLoanLedgerEntryRequest;
use App\Http\Requests\UpdateCreditLoanLedgerEntryRequest;
use App\Http\Resources\CreditLoanLedgerEntryResource;
use App\Models\CreditLoanLedgerEntry;

final class CreditLoanLedgerEntryController extends DomainResourceController
{
    protected string $modelClass = CreditLoanLedgerEntry::class;

    protected string $resourceClass = CreditLoanLedgerEntryResource::class;

    protected string $storeRequestClass = StoreCreditLoanLedgerEntryRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanLedgerEntryRequest::class;

    protected bool $allowDirectWrites = false;
}
