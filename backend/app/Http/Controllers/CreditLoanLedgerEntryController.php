<?php

namespace App\Http\Controllers\Domain;

use App\Http\Requests\Domain\StoreCreditLoanLedgerEntryRequest;
use App\Http\Requests\Domain\UpdateCreditLoanLedgerEntryRequest;
use App\Http\Resources\Domain\CreditLoanLedgerEntryResource;
use App\Models\Domain\CreditLoanLedgerEntry;

final class CreditLoanLedgerEntryController extends DomainResourceController
{
    protected string $modelClass = CreditLoanLedgerEntry::class;

    protected string $resourceClass = CreditLoanLedgerEntryResource::class;

    protected string $storeRequestClass = StoreCreditLoanLedgerEntryRequest::class;

    protected string $updateRequestClass = UpdateCreditLoanLedgerEntryRequest::class;

    protected bool $allowDirectWrites = false;
}
